USE [evoucher_development]
GO

/****** Object:  View [dbo].[vw_redeem_landing_page_outlets]    Script Date: 11/08/2018 23.22.37 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE VIEW [dbo].[vw_redeem_landing_page_outlets]
AS
     SELECT bcv.campaign_id,
            bcv.campaign_voucher_id,
            mo.outlets_address_province_pid,
            pg.parameters_value AS province,
            mm.merchant_id,
            mm.merchant_title,
            mo.outlets_title,
            mo.outlets_address_line+' - '+pc.parameters_value+',  '+reg.parameters_value AS address_line
     FROM dbo.bsn_campaign_vouchers bcv
          INNER JOIN dbo.bsn_campaign_voucher_outlets bcvo ON bcv.campaign_voucher_id = bcvo.campaign_voucher_id
          INNER JOIN dbo.mch_outlets mo ON bcvo.outlets_id = mo.outlets_id
          INNER JOIN dbo.mch_merchant mm ON mo.merchant_id = mm.merchant_id
          INNER JOIN dbo.frm_global_parameters pg ON mo.outlets_address_province_pid = pg.parameters_id
          INNER JOIN dbo.frm_global_parameters pc ON mo.outlets_address_city_pid = pc.parameters_id
          INNER JOIN dbo.frm_global_parameters reg ON mo.outlets_address_region_pid = reg.parameters_id;


GO


