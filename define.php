<?php
	
	// ====================== PATHS ===========================
	define ('DS'				, '/');
	define ('ROOT_PATH'			, dirname(__FILE__));						// Định nghĩa đường dẫn đến thư mục gốc
	define ('LIBRARY_PATH'		, ROOT_PATH . DS . 'libs' . DS);			// Định nghĩa đường dẫn đến thư mục thư viện
	define ('PUBLIC_PATH'		, ROOT_PATH . DS . 'public' . DS);			// Định nghĩa đường dẫn đến thư mục public							
	define ('APPLICATION_PATH'	, ROOT_PATH . DS . 'application' . DS);		// Định nghĩa đường dẫn đến thư mục public		
	define ('MODULE_PATH'		, APPLICATION_PATH . 'module' . DS);		// Định nghĩa đường dẫn đến thư mục module							
	define ('TEMPLATE_PATH'		, PUBLIC_PATH . 'template' . DS);		// Định nghĩa đường dẫn đến thư mục public							
	define ('BLOCK_PATH'		, APPLICATION_PATH . 'block' . DS);		
	define ('LIBRARY_EXT_PATH'	, LIBRARY_PATH . 'extends' . DS);	
	define ('UPLOAD_PATH'		, PUBLIC_PATH  . 'files' . DS);	
	define ('SCRIPT_PATH'		, PUBLIC_PATH  . 'scripts' . DS);	
	
	define	('ROOT_URL'			, DS );
	define	('APPLICATION_URL'	, ROOT_URL . 'application' . DS);
	define	('PUBLIC_URL'		, ROOT_URL . 'public' . DS);
	define	('TEMPLATE_URL'		, PUBLIC_URL . 'template' . DS);

	define	('UPLOAD_URL'		, PUBLIC_URL . 'files' . DS);
	
	define	('DEFAULT_MODULE'		, 'default');
	define	('DEFAULT_CONTROLLER'	, 'index');
	define	('DEFAULT_ACTION'		, 'index');

	// ====================== DATABASE ===========================
	define ('DB_HOST'			, 'localhost');
	define ('DB_USER'			, 'root');						
	define ('DB_PASS'			, '');						
	define ('DB_NAME'			, 'bookstore');						
	define ('DB_TABLE'			, 'group');			
	
	
	define ('TBL_GROUP'			, 'group');
	define ('TBL_USER'			, 'user');
	define ('TBL_PRIVELEGE'		, 'privilege');
	define ('TBL_CATEGORY'		, 'category');
	define ('TBL_BOOK'			, 'book');
	define ('TBL_CART'			, 'cart');

	define ('TIME_LOGIN'		, 3600);