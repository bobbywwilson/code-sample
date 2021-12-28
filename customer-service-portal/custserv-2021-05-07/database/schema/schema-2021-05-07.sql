create table [Database].[dbo].[roles] (
	id int IDENTITY(1,1) PRIMARY KEY,
	description varchar(255) NOT NULL UNIQUE,
	created_date DATETIME NOT NULL DEFAULT GETDATE(),
	updated_date DATETIME NULL
);

create table [Database].[dbo].[users] (
	id int IDENTITY(1,1),
	role_id int NOT NULL,
	username varchar(255) NOT NULL UNIQUE,
	first_name varchar(255) NOT NULL,
	last_name varchar(255) NOT NULL,
	password varchar(255) NOT NULL,
	email varchar(255) NOT NULL UNIQUE,
	last_login DATETIME NOT NULL DEFAULT GETDATE(),
	created_date DATETIME NOT NULL DEFAULT GETDATE(),
	updated_date DATETIME NULL,
	PRIMARY KEY (id),
	CONSTRAINT FK_RolesUsers_Id FOREIGN KEY (role_id)
	REFERENCES [Database].[dbo].[roles] (id)
);

create table [Database].[dbo].[companies] (
	id int IDENTITY(1,1),
	user_id int NOT NULL,
	company_name varchar(255) NOT NULL,
	company_contact varchar(255) NOT NULL,
	contact_phone varchar(14) NOT NULL,
	contact_email varchar(255) NOT NULL,
	created_date DATETIME NOT NULL DEFAULT GETDATE(),
	updated_date DATETIME NULL,
	PRIMARY KEY (id),
	CONSTRAINT FK_UsersCompanies_Id FOREIGN KEY (user_id)
	REFERENCES [Database].[dbo].[users] (id)
	ON DELETE CASCADE,
	CONSTRAINT unique_userIdCompanyName UNIQUE (user_id, company_name)
);

create table [Database].[dbo].[products] (
	id int IDENTITY(1,1),
	company_id int NOT NULL,
	product_name varchar(255) NOT NULL,
	license_type varchar(255) NOT NULL,
	created_date DATETIME NOT NULL DEFAULT GETDATE(),
	updated_date DATETIME NULL,
	PRIMARY KEY (id),
	CONSTRAINT FK_CompaniesProducts_Id FOREIGN KEY (company_id)
	REFERENCES [Database].[dbo].[companies] (id)
	ON DELETE CASCADE,
	CONSTRAINT unique_companyIdProductName UNIQUE (company_id, product_name)
);
