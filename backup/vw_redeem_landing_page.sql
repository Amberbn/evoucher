USE [evoucher_development]
GO

/****** Object:  View [dbo].[vw_redeem_landing_page]    Script Date: 11/08/2018 22.56.33 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE VIEW [dbo].[vw_redeem_landing_page]
AS
     SELECT c.campaign_id,
            v.campaign_voucher_id,
            c.campaign_message_title, -- tulisan dibawah congratulation
            v.campaign_voucher_title,
            CASE
                WHEN ISNULL(ot.CountMerchant, 0) = 1
                THEN mch.merchant_title
                WHEN ISNULL(ot.CountMerchant, 0) > 1
                THEN 'Eligible in '+CAST(ot.CountMerchant AS VARCHAR)+' merchant'
                ELSE 'Merchant unkown, please contact admin'
            END AS Merchant,
            v.campaign_voucher_main_image_url, -- gambar voucher
	 -- TAB 1 (Informasi)
            v.campaign_voucher_information,
            v.campaign_voucher_short_information, -- cara penukaran voucher
	-- TAB 2
            v.campaign_voucher_valid_end_date, -- masa berlaku
            v.campaign_voucher_terms_and_condition, --syarat dan ketentuan
	-- TAB 3
            vg.voucher_generated_no, -- Nomor Voucher
	-- Footer (Social Media Icon Link),
            mch.merchant_socmed_url_facebook,
            mch.merchant_socmed_url_instagram,
            mch.merchant_socmed_url_twitter
     FROM dbo.bsn_campaign c
          INNER JOIN dbo.bsn_campaign_vouchers v ON c.campaign_id = v.campaign_id
          INNER JOIN dbo.vou_voucher_generated vg ON v.campaign_voucher_id = vg.campaign_voucher_id
          LEFT JOIN
(
    SELECT campaign_voucher_id,
           COUNT(vo.outlets_id) CountMerchant
    FROM dbo.bsn_campaign_voucher_outlets vo
    GROUP BY campaign_voucher_id
) ot ON v.campaign_voucher_id = ot.campaign_voucher_id
          LEFT JOIN
(
    SELECT campaign_voucher_id,
           merchant_title,
           merchant_socmed_url_facebook,
           merchant_socmed_url_instagram,
           merchant_socmed_url_twitter
    FROM
(
    SELECT mm.merchant_title,
           vo.campaign_voucher_id,
           mm.merchant_socmed_url_facebook,
           mm.merchant_socmed_url_instagram,
           mm.merchant_socmed_url_twitter,
           ROW_NUMBER() OVER(PARTITION BY vo.campaign_voucher_id ORDER BY mm.merchant_id DESC) AS RowIdx
    FROM dbo.bsn_campaign_voucher_outlets vo
         INNER JOIN dbo.mch_merchant mm ON vo.merchant_id = mm.merchant_id
) main
    WHERE RowIdx = 1
) mch ON v.campaign_voucher_id = mch.campaign_voucher_id;

GO


