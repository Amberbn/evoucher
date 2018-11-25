SELECT mm.merchant_id,
       mm.merchant_code,
       mm.client_id,
       bc.client_code,
       bc.client_name,
       mm.merchant_title,
       mm.merchant_bussiness_category_pid,
       bcat.parameters_value AS merchant_bussiness_category_title,
       mm.merchant_description,
       mm.merchant_tags,
       mm.data_sort,
       mm.isactive,
       mm.isdelete,
       mm.created_at,
       mm.created_by_user_name,
       mm.updated_at,
       mm.last_updated_by_user_name
FROM dbo.mch_merchant mm
     INNER JOIN dbo.bsn_client bc ON mm.client_id = bc.client_id
     INNER JOIN frm_global_parameters bcat ON mm.merchant_bussiness_category_pid = bcat.parameters_id
WHERE mm.isactive = 1;

