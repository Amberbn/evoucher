ALTER TABLE [dbo].[frm_resources] DROP CONSTRAINT [FK_frm_resources_frm_roles]
GO
/****** Object:  Table [dbo].[frm_resources]    Script Date: 29/07/2018 18.59.05 ******/
DROP TABLE [dbo].[frm_resources]
GO
/****** Object:  Table [dbo].[frm_resources]    Script Date: 29/07/2018 18.59.05 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[frm_resources](
	[resources_id] [bigint] IDENTITY(1,1) NOT NULL,
	[roles_id] [bigint] NOT NULL,
	[resources_group] [varchar](128) NULL,
	[resources_object] [varchar](128) NULL,
	[resources_type] [varchar](128) NULL,
	[resources_event] [varchar](128) NULL,
	[resources_isallow] [bit] NULL,
	[resources_helper] [varchar](2048) NULL,
	[resources_description] [varchar](256) NULL,
 CONSTRAINT [PK_frm_resources] PRIMARY KEY CLUSTERED 
(
	[resources_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET IDENTITY_INSERT [dbo].[frm_resources] ON 

INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (33, 2, NULL, N'user', NULL, N'create', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (34, 2, NULL, N'user', NULL, N'read', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (35, 2, NULL, N'user', NULL, N'update', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (36, 2, NULL, N'user', NULL, N'delete', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (37, 2, NULL, N'client', NULL, N'create', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (38, 2, NULL, N'client', NULL, N'read', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (39, 2, NULL, N'client', NULL, N'update', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (40, 2, NULL, N'client', NULL, N'delete', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (41, 2, NULL, N'campaign', NULL, N'create', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (42, 2, NULL, N'campaign', NULL, N'read', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (43, 2, NULL, N'campaign', NULL, N'update', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (44, 2, NULL, N'campaign', NULL, N'delete', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (45, 2, NULL, N'voucher', NULL, N'create', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (46, 2, NULL, N'voucher', NULL, N'read', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (47, 2, NULL, N'voucher', NULL, N'update', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (48, 2, NULL, N'voucher', NULL, N'delete', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (49, 2, NULL, N'merchant', NULL, N'create', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (50, 2, NULL, N'merchant', NULL, N'read', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (51, 2, NULL, N'merchant', NULL, N'update', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (52, 2, NULL, N'merchant', NULL, N'delete', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (53, 2, NULL, N'invoice', NULL, N'create', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (54, 2, NULL, N'invoice', NULL, N'read', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (55, 2, NULL, N'invoice', NULL, N'update', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (56, 2, NULL, N'invoice', NULL, N'delete', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (57, 2, NULL, N'deposit', NULL, N'create', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (58, 2, NULL, N'deposit', NULL, N'read', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (59, 2, NULL, N'deposit', NULL, N'update', 1, NULL, NULL)
INSERT [dbo].[frm_resources] ([resources_id], [roles_id], [resources_group], [resources_object], [resources_type], [resources_event], [resources_isallow], [resources_helper], [resources_description]) VALUES (60, 2, NULL, N'deposit', NULL, N'delete', 1, NULL, NULL)
SET IDENTITY_INSERT [dbo].[frm_resources] OFF
ALTER TABLE [dbo].[frm_resources]  WITH CHECK ADD  CONSTRAINT [FK_frm_resources_frm_roles] FOREIGN KEY([roles_id])
REFERENCES [dbo].[frm_roles] ([roles_id])
GO
ALTER TABLE [dbo].[frm_resources] CHECK CONSTRAINT [FK_frm_resources_frm_roles]
GO
