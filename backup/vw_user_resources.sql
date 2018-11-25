
/****** Object:  View [dbo].[vw_user_resources]    Script Date: 29/07/2018 19.09.02 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE VIEW [dbo].[vw_user_resources] AS 
SELECT main.user_id,
       main.user_name,
       main.resources_group,
       main.resources_object,
       main.resources_type,
       main.resources_event,
       main.resources_isallow,
       main.resources_helper,
       main.resources_description
FROM
(
    SELECT DISTINCT
           usr.user_id,
           usr.user_name,
           rs.resources_group,
           rs.resources_object,
           rs.resources_type,
           rs.resources_event,
           rs.resources_isallow,
           rs.resources_helper,
           rs.resources_description,
           ROW_NUMBER() OVER(PARTITION BY usr.user_id,
                                          usr.user_name,
                                          rs.resources_group,
                                          rs.resources_object,
                                          rs.resources_type,
                                          rs.resources_event,
                                          rs.resources_helper,
                                          rs.resources_description ORDER BY rs.resources_isallow DESC) AS "RN"
    FROM dbo.frm_user usr
         INNER JOIN dbo.frm_user_roles urol ON usr.user_id = urol.user_id
         INNER JOIN dbo.frm_roles rl ON urol.roles_id = rl.roles_id
         INNER JOIN dbo.frm_resources rs ON rl.roles_id = rs.roles_id
) main
WHERE RN = 1
      


GO


