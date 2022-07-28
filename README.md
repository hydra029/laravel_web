# laravel_web
 # laravel_web
 Tài liệu đồ án web quản lý lương nhân viên

1.	Đối tượng sử dụng
a.	CEO
b.	Kế toán
c.	Quản lý phòng ban
d.	Nhân viên
2.	Chức năng từng đối tượng
a.	CEO
i.	Đăng nhập
ii.	Đăng xuất
iii.	Quản lý thông tin cá nhân
iv.	Thêm tài khoản
v.	Thay đổi khung giờ điểm danh
vi.	Thay đổi lương phòng ban – vị trí
vii.	Quản lý bảng lương toàn công ty
viii.	Quản lý nhân viên toàn công ty
b.	Kế toán
i.	Đăng nhập
ii.	Đăng xuất
iii.	Quản lý thông tin cá nhân
iv.	Điểm danh
v.	Xem lương cá nhân
vi.	Xem lịch sử điểm danh
vii.	Xác nhận bảng lương của các phòng ban
viii.	Báo cáo phản hồi lỗi với quản trị viên
c.	Quản lý phòng ban
i.	Đăng nhập
ii.	Đăng xuất
iii.	Điểm danh
iv.	Quản lý bảng lương phòng ban
v.	Quản lý nhân viên của phòng ban
vi.	Quản lý điểm danh của phòng ban
vii.	Quản lý lương của phòng ban
d.	Nhân viên
i.	Đăng nhập
ii.	Đăng xuất
iii.	Xem thông tin cá nhân
iv.	Điểm danh
v.	Xem lương
vi.	Xem lịch sử điểm danh
vii.	Báo cáo phản hồi lỗi với quản trị viên

 
3.	Phân tích chức năng
	Đăng nhập
Các nhân tố	Quản trị viên, Nhân viên
Mô tả	Đăng nhập
Kích hoạt	Truy cập trang web
Đầu vào	a.	Không
Trình tự xử lý	1.	Lấy thông tin từ form
2.	Kiểm tra dữ liệu trong database
Đầu ra	•	Hiển thị trang chủ
Lưu ý	Có sự khác biệt giữa trang chủ của nhân viên và quản trị viên

	Đăng xuất
Các nhân tố	Quản trị viên, Nhân viên
Mô tả	Đăng xuất
Kích hoạt	Người dùng ấn vào nút “Đăng xuất” trên thanh menu
Đầu vào	Không
Trình tự xử lý	1.	Chuyển sang trang đăng nhập 
Đầu ra	•	Hiển thị trang thông tin về các nhân viên
Lưu ý	

 
	Quản lý nhân viên
Các nhân tố	Quản trị viên
Mô tả	Quản lý nhân viên
Kích hoạt	Người dùng ấn vào nút “Quản lý nhân viên” trên thanh menu
Đầu vào	Không
Trình tự xử lý	1.	Chuyển sang trang quản lý nhân viên
2.	Hiển thị các thông tin 
Đầu ra	•	Hiển thị trang thông tin về các nhân viên
Lưu ý	

	Thêm nhân viên
Các nhân tố	Quản trị viên
Mô tả	Thêm nhân viên
Kích hoạt	Người dùng ấn vào nút “Thêm nhân viên” trên thanh menu
Đầu vào	Không
Trình tự xử lý	1.	Chuyển sang trang thêm nhân viên
2.	Lấy dữ liệu từ form
Đầu ra	•	Hiển thị trang chủ quản trị viên
•	Thông báo đăng ký thành công
Lưu ý	
 
	Quản lý điểm danh
Các nhân tố	Quản trị viên
Mô tả	Quản lý điểm danh
Kích hoạt	Người dùng ấn vào nút “Quản lý điểm danh” trên thanh menu
Đầu vào	Không
Trình tự xử lý	1.	Chuyển sang trang quản lý nhân viên
2.	Hiển thị các thông tin 
Đầu ra	•	Đúng: Hiển thị trang thông tin về các nhân viên
•	Sai: 
Lưu ý	

	Quản lý lương
Các nhân tố	Quản trị viên
Mô tả	Quản lý lương
Kích hoạt	Người dùng ấn vào nút “Quản lý nhân viên” trên thanh menu
Đầu vào	Không
Trình tự xử lý	1.	Chuyển sang trang quản lý nhân viên
2.	Hiển thị các thông tin 
Đầu ra	•	Đúng: Hiển thị trang thông tin về các nhân viên
•	Sai: 
Lưu ý	

 
	Xem thông tin cá nhân
Các nhân tố	Quản trị viên
Mô tả	Xem thông tin bản thân
Kích hoạt	Người dùng ấn vào nút “Thông tin cá nhân” trên thanh menu
Đầu vào	ID người dùng
Trình tự xử lý	1.	Chuyển sang trang quản lý nhân viên
2.	Hiển thị các thông tin
Đầu ra	Hiển thị trang thông tin về các nhân viên 
Lưu ý	

	Điểm danh
Các nhân tố	Quản trị viên
Mô tả	Điểm danh
Kích hoạt	Người dùng ấn vào nút “Điểm danh” trên thanh menu
Đầu vào	Không
Trình tự xử lý	1.	Chuyển sang trang quản lý nhân viên
2.	Hiển thị các thông tin 
Đầu ra	Hiển thị trang thông tin về các nhân viên 
Lưu ý	

 
	Xem lịch sử điểm danh
Các nhân tố	Quản trị viên
Mô tả	Điểm danh
Kích hoạt	Người dùng ấn vào nút “Điểm danh” trên thanh menu
Đầu vào	Không
Trình tự xử lý	1.	Chuyển sang trang quản lý nhân viên
2.	Hiển thị các thông tin 
Đầu ra	Hiển thị trang thông tin về các nhân viên 
Lưu ý	

	Báo cáo phản hổi lỗi
Các nhân tố	Quản trị viên
Mô tả	Điểm danh
Kích hoạt	Người dùng ấn vào nút “Điểm danh” trên thanh menu
Đầu vào	Không
Trình tự xử lý	1.	Chuyển sang trang quản lý nhân viên
2.	Hiển thị các thông tin 
Đầu ra	Hiển thị trang thông tin về các nhân viên
Lưu ý	

 
	Điểm danh
Các nhân tố	Quản trị viên
Mô tả	Điểm danh
Kích hoạt	Người dùng ấn vào nút “Điểm danh” trên thanh menu
Đầu vào	Không
Trình tự xử lý	1.	Chuyển sang trang quản lý nhân viên
2.	Hiển thị các thông tin 
Đầu ra	Hiển thị trang thông tin về các nhân viên 
Lưu ý	






