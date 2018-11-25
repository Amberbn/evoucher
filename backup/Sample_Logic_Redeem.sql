CREATE PROCEDURE sp_campaign_voucher_redeem (@voucher_number VARCHAR(64), 
@outlet_authentification_code AS VARCHAR(64), @reference_id AS VARCHAR(256)) AS

BEGIN

--variabel2 yang dilempar ke API redeem
--DECLARE @voucher_number AS VARCHAR(64)= '201806051828-830606-613227';
--DECLARE @outlet_authentification_code AS VARCHAR(64)= '159196';
--DECLARE @reference_id AS VARCHAR(256)='REQUESTAPI20180702';


--buat variable buat simpen parameter validasi
DECLARE @redeemfailurecode AS VARCHAR(1000);
DECLARE @campaign_voucher_id AS BIGINT;
DECLARE @voucher_generated_no AS VARCHAR(256);
DECLARE @campaign_status AS VARCHAR(256);
DECLARE @campaign_period_start_date AS DATETIME;
DECLARE @campaign_period_end_date AS DATETIME;
DECLARE @campaign_voucher_valid_start_date AS DATETIME;
DECLARE @campaign_voucher_valid_end_date AS DATETIME;
DECLARE @voucher_generated_is_redeemed AS BIT;
DECLARE @voucher_generated_locked_till AS DATETIME;
DECLARE @outlets_id AS BIGINT;
DECLARE @merchant_id AS BIGINT;
DECLARE @voucher_generated_fail_counter AS INT;
DECLARE @voucher_generated_id AS BIGINT;
DECLARE @LockedMinutes AS VARCHAR(500);

--Load data voucher untuk dasar pengecekan
SELECT TOP 1 @campaign_voucher_id = campaign_voucher_id,
             @voucher_generated_id = voucher_generated_id,
             @voucher_generated_no = voucher_generated_no,
             @campaign_status = campaign_status,
             @campaign_period_start_date = campaign_period_start_date,
             @campaign_period_end_date = campaign_period_end_date,
             @campaign_voucher_valid_start_date = campaign_voucher_valid_start_date,
             @campaign_voucher_valid_end_date = campaign_voucher_valid_end_date,
             @voucher_generated_is_redeemed = voucher_generated_is_redeemed,
             @voucher_generated_locked_till = voucher_generated_locked_till,
             @voucher_generated_fail_counter = ISNULL(voucher_generated_fail_counter, 0)
FROM dbo.vw_redeem_check_voucher
WHERE voucher_generated_no = @voucher_number

--Load data outlet voucher untuk dasar pengecekan
SELECT TOP 1 @outlets_id = outlets_id,
             @merchant_id = merchant_id
FROM dbo.vw_redeem_check_outlet
WHERE campaign_voucher_id = @campaign_voucher_id AND 
outlets_auth_code = @outlet_authentification_code

-- cek error condition
IF @voucher_generated_id IS NULL
   BEGIN
		SELECT @redeemfailurecode = 'INV'; --Voucher invalid (tidak dikenali)
    END;
    ELSE
IF @voucher_generated_locked_till IS NOT NULL
   AND @voucher_generated_locked_till > GETDATE() -- cek apakah voucher terkunci (tanggal kunci (voucher_locked_till) lebih besar dari tanggal saat ini)
    BEGIN
        SELECT @LockedMinutes = CAST(DATEDIFF(Minute, GETDATE(), @voucher_generated_locked_till) AS VARCHAR(100)); --Cek berapa menit lagi voucher terkunci
        SELECT @redeemfailurecode = 'Locked for '+@LockedMinutes+' min.'; --message return ke front end
    END;
    ELSE
IF @voucher_generated_is_redeemed = 1
    BEGIN
        SELECT @redeemfailurecode = 'RF01'; --Voucher sudah di redeem sebelumnya
    END;
    ELSE
IF GETDATE() < @campaign_voucher_valid_start_date
   OR GETDATE() < @campaign_period_start_date
    BEGIN
        SELECT @redeemfailurecode = 'RF02'; --Voucher tidak dapat di redeem sebelum masa berlaku voucher atau campaign dimulai
    END;
    ELSE
IF GETDATE() > @campaign_voucher_valid_end_date
   OR GETDATE() > @campaign_period_end_date
    BEGIN
        SELECT @redeemfailurecode = 'RF03'; --Masa berlaku voucher atau campaign sudah berakhir

    END;
    ELSE
IF @outlets_id IS NULL
    BEGIN
        SELECT @redeemfailurecode = 'RF04'; --Voucher tidak dapat di redeem pada outlet yang diinput (voucher tidak di set pada outlet tersebut)
    END;



--Return Result Failure
	IF (@voucher_generated_locked_till IS NOT NULL
	   AND @voucher_generated_locked_till > GETDATE()) OR  @voucher_generated_id IS NULL  --kalau sedang terkunci/ atau nomor voucher gk ada tidak usah simpan kegagalan ke database  
	   BEGIN
	   SELECT 
				@voucher_generated_no AS voucher_number,
				GETDATE() as redeem_request_date,
				@reference_id AS redeem_request_id,
				'000' AS redeem_status_code,
				@redeemfailurecode AS redeem_failure_code
	   END;
	ELSE
	IF @redeemfailurecode IS NOT NULL --Jika validasi redeem gagal, tambahkan counter dan simpan ke redeem table
    BEGIN
		-- kunci voucher jika 5x gagal redeem
        IF @voucher_generated_fail_counter = 4
            BEGIN
			UPDATE vou_voucher_generated
              SET
                  voucher_generated_locked_till = DATEADD(MINUTE, 10, GETDATE()), --tambah waktu kunci
				  voucher_generated_fail_counter = 0 --reset counter
            WHERE voucher_generated_no = @voucher_number;

			--return respond
				SELECT 
				@voucher_generated_no AS voucher_number,
				GETDATE() as redeem_request_date,
				@reference_id AS redeem_request_id,
				'000' AS redeem_status_code,
				'Locked for 10 min.' AS redeem_failure_code

			END
            ELSE
        --Tambahin Counter kalau masih dibawah 5
        IF @voucher_generated_fail_counter <= 3
		BEGIN
		UPDATE vou_voucher_generated
          SET
              voucher_generated_fail_counter = ISNULL(voucher_generated_fail_counter,0) + 1
        WHERE voucher_generated_no = @voucher_number;

		--insert result 
		INSERT vou_redeem
		VALUES
			(
				@voucher_generated_id,
				@voucher_generated_no,
				0, --redeem_is_approved,
				@outlets_id, --outlets_id,
				@merchant_id, --merchant_id,
				GETDATE(), --created_at,
				@reference_id, --redeem_request_id,
				000,--redeem_status_code (000=fail, 001=success)
				@redeemfailurecode --redeem_failure_code
			) 

		--return respond
		SELECT 
				@voucher_generated_no AS voucher_number,
				GETDATE() as redeem_request_date,
				@reference_id AS redeem_request_id,
				'000' AS redeem_status_code,
				@redeemfailurecode AS redeem_failure_code
		END
    END;
	ELSE
		IF @redeemfailurecode IS NULL --Jika validasi redeem sukses
		BEGIN
		
		--insert result
		INSERT vou_redeem
		VALUES
			(
				@voucher_generated_id,
				@voucher_generated_no,
				1, --redeem_is_approved,
				@outlets_id, --outlets_id,
				@merchant_id, --merchant_id,
				GETDATE(), --created_at,
				@reference_id, --redeem_request_id,
				001,--redeem_status_code (000=fail, 001=success)
				NULL --redeem_failure_code
			) 

		UPDATE vou_voucher_generated
            SET voucher_generated_is_redeemed = 1,
			voucher_generated_redeem_id = SCOPE_IDENTITY() -- ambil id yang barusan di insert ke reddem table 
        WHERE voucher_generated_no = @voucher_number; 
		
		--return respond
		SELECT 
				@voucher_generated_no AS voucher_number,
				GETDATE() as redeem_request_date,
				@reference_id AS redeem_request_id,
				'001' AS redeem_status_code,
				@redeemfailurecode AS redeem_failure_code

	END;
	END