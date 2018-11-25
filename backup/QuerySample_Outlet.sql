SELECT mo.outlets_id,
       mo.outlets_code,
       mo.merchant_id,
       mm.merchant_code,
       mm.merchant_title,
       mo.client_id,
       cl.client_code,
       cl.client_name,
       mo.outlets_title,
       mo.outlets_email,
       mo.outlets_phone,
       mo.outlets_description,
       mo.outlets_address_line,
       mo.outlets_address_province_pid,
       prov.parameters_value AS outlets_address_province_title,
       mo.outlets_address_city_pid,
       city.parameters_value AS outlets_address_city_title,
       mo.outlets_address_region_pid,
       reg.parameters_value AS outlets_address_region_title,
       mo.outlets_location_coordinates,
       mo.outlets_auth_code,
       mo.data_sort,
       mo.isactive,
       mo.isdelete,
       mo.created_at,
       mo.created_by_user_name,
       mo.updated_at,
       mo.last_updated_by_user_name
FROM dbo.mch_outlets mo
     INNER JOIN bsn_client cl ON mo.client_id = cl.client_id
     INNER JOIN dbo.mch_merchant mm ON mo.merchant_id = mm.merchant_id
     INNER JOIN frm_global_parameters prov ON mo.outlets_address_province_pid = prov.parameters_id
     INNER JOIN frm_global_parameters city ON mo.outlets_address_city_pid = city.parameters_id
     INNER JOIN frm_global_parameters reg ON mo.outlets_address_region_pid = reg.parameters_id
WHERE mo.isdelete = 0;