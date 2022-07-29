# Tài liệu đồ án web quản lý lương nhân viên

### Mục đích 

Hỗ trợ thực hiện công việc chấm công điểm danh và tính lương của nhân viên.
### Đối tượng sử dụng

-	Ceo
-	Kế toán
-	Quản lý phòng ban
-	Nhân viên

### Chức năng từng đối tượng

1. 	CEO
-	Đăng nhập
-	Đăng xuất
-	Quản lý thông tin cá nhân
-	Thêm tài khoản
-	Thay đổi khung giờ điểm danh
-	Thay đổi lương phòng ban – vị trí
-	Quản lý bảng lương toàn công ty
-	Quản lý nhân viên toàn công ty
2. 	Kế toán
-	Đăng nhập
-	Đăng xuất
-	Quản lý thông tin cá nhân
-	Điểm danh
-	Xem lương cá nhân
-	Xem lịch sử điểm danh
-	Xác nhận bảng lương của các phòng ban
-	Báo cáo phản hồi lỗi với quản trị viên
3. 	Quản lý 
-	Đăng nhập
-	Đăng xuất
-	Điểm danh
-	Quản lý bảng lương phòng ban
-	Quản lý nhân viên của phòng ban
-	Quản lý điểm danh của phòng ban
-	Quản lý lương của phòng ban
4. 	Nhân viên
-	Đăng nhập
-	Đăng xuất
-	Xem thông tin cá nhân
-	Điểm danh
-	Xem lương
-	Xem lịch sử điểm danh
-	Báo cáo phản hồi lỗi với quản trị viên

### Phân tích chức năng

1. :inbox_tray: Đăng nhập
 

| Các tác nhân | Tất cả tài khoản |
| ------ | ------ |
| Mô tả | Đăng nhập |
| Kích hoạt | Truy cập trang web thực hiện đăng nhập |
| Đầu vào | Email<br>Password |
| Trình tự xử lý | Lấy thông tin từ form<br>Kiểm tra dữ liệu trong database|
| Đầu ra | Đúng: Hiển thị trang người dùng và thông báo thành công<br>Sai: Hiển thị trang đăng nhập và thông báo thất bại |
| Lưu ý | Có sự khác biệt giữa trang chủ của nhân viên và quản trị viên |

2. :outbox_tray: Đăng xuất


| Các tác nhân | Tất cả tài khoản |
| ------ | ------ |
| Mô tả | Đăng xuất |
| Kích hoạt | Người dùng ấn vào nút “Đăng xuất” trên thanh menu |
| Đầu vào | Không |
| Trình tự xử lý | Chuyển sang trang đăng nhập |
| Đầu ra | |
| Lưu ý | |

3. 	:teacher: Thêm tài khoản 

| Các tác nhân | Ceo, quản lý  |
| ------ | ------ |
| Mô tả | Thêm tài khioản cho người dùng |
| Kích hoạt | Nhấn vào nút thêm tài khoản |
| Đầu vào | Thông tin người dùng |
| Trình tự xử lý | Lưu lại thông tin người dùng |
| Đầu ra | Trả lại thông tin người dùng |
| Lưu ý | Quản lý chỉ có thể thêm tài khoản cho nhân viên thuộc phòng ban của mình |

4. :watch: Điểm danh

| Các tác nhân | Quản lý, kế toán, nhân viên  |
| ------ | ------ |
| Mô tả | Điểm danh |
| Kích hoạt | Nhấn vào nút điểm danh |
| Đầu vào | Id<br>Thời gian điểm danh |
| Trình tự xử lý | Lưu lại thông tin điểm danh<br>Kiểm tra thời gian diểm danh xem đúng giò, muộn hay trễ |
| Đầu ra | Xác nhận đã điểm danh |
| Lưu ý | |

5. :bust_in_silhouette: Quản lý nhân viên

| Các tác nhân | Ceo, Quản lý  |
| ------ | ------ |
| Mô tả | Quản lý thông tin nhân viên, sửa xóa nhân viên |
| Kích hoạt | Thực hiện các tác vụ trong phần quản lý nhân viên |
| Đầu vào | Mã nhân viên |
| Trình tự xử lý |Xem: lấy thông tin cá nhân của nhân viên<br>Sửa: sửa thông tin theo dữ liệu truyền vào<br>Xóa: xóa nhân viên |
| Đầu ra | Trả về kết quả |
| Lưu ý | |

6. :calendar: Quản lý điểm danh

| Các tác nhân | Quản lý  |
| ------ | ------ |
| Mô tả | Quản lý điểm danh của nhân viên |
| Kích hoạt | Thực hiện các tác vụ trong phần quản lý điểm danh|
| Đầu vào | Thông tin điểm danh |
| Trình tự xử lý | Kiểm tra thông tin điểm danh |
| Đầu ra | Đúng: xác nhận đúng, truyền dữ liệu để tạo bảng lương <br>Sai: trả lại thông báo cho nhân viên|
| Lưu ý | Nếu thông tin điểm danh sai quản lý và nhân viên xác nhận lại và thay đổi thông tin điểm danh |
