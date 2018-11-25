SELECT cat.voucher_catalog_id
      ,cat.voucher_catalog_revision_no
      ,cat.merchant_client_id
      ,bc.client_name
      ,cat.voucher_catalog_sku_code
      ,cat.voucher_catalog_title
      ,cat.voucher_catalog_main_image_url
      ,cat.voucher_catalog_information
      ,cat.voucher_catalog_terms_and_condition
      ,cat.voucher_catalog_instruction_customer
      ,cat.voucher_catalog_instruction_outlet
      ,cat.voucher_catalog_valid_start_date
      ,cat.voucher_catalog_valid_end_date
      ,cat.voucher_catalog_tags
      ,cat.voucher_catalog_value_amount
      ,cat.voucher_catalog_value_point
      ,cat.voucher_catalog_unit_price_amount
      ,cat.voucher_catalog_unit_price_point
      ,cat.voucher_catalog_stock_level
      ,cat.voucher_status
      ,cat.data_sort
      ,cat.isactive
      ,cat.isdelete
      ,cat.created_at
      ,cat.created_by_user_name
      ,cat.updated_at
      ,cat.last_updated_by_user_name FROM vou_voucher_catalog cat
      INNER JOIN bsn_client bc ON cat.merchant_client_id = bc.client_id
      WHERE cat.isdelete = 0


