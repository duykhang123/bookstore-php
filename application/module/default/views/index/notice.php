<?php

	$message	= '';
	switch ($this->arrParams['type']){
		case 'register-success':
			$message	= 'Tài khoản của bạn đã được tạo thành công. Xin vui lòng chờ kích hoạt từ người quản trị!';
			break;
		case 'not-permission':
			$message	= 'Bạn không có quyền truy cập vào chức năng đó!';
			break;
		case 'not-url':
			$message	= 'Đường dẫn không hợp lệ!';
			break;
	}
?>
<div class="notice"><?php echo $message;?></div>