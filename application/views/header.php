<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>[Localhost] Login ID Reader Website</title>
	<link rel="icon" href="<?php echo base_url(); ?>img/logo.ico" type="image/png">
		<!-- Include SweetAlert2 CSS and JS files -->
		<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		<script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
		<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300&display=swap" rel="stylesheet">

	<!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

	<script>
	// เมื่อหน้าเว็บโหลดเสร็จแล้ว
	document.addEventListener('DOMContentLoaded', function() {
		// ทำ HTTP request เพื่อดึงข้อมูลจาก ID Reader กรณนี้คือดึงมาโดยอัตโนมัติ ไม่ต้องกดปุ่มอะไร
		axios.get('http://localhost:5000/')
			.then(function (response) {
				// เมื่อรับข้อมูลสำเร็จ
				var result = response.data;

				// นำข้อมูลมาแสดงในฟอร์ม
				document.querySelector('input[name="id_number"]').value = result['ID Number'];
				document.querySelector('input[name="th_name"]').value = result['Thai Name'];
				document.querySelector('input[name="en_name"]').value = result['English Name'];
			})
			.catch(function (error) {
				// กรณีเกิดข้อผิดพลาดในการรับข้อมูล
				console.error('Error fetching data from ID Reader:', error);
			});
	});
	</script> -->
	
	<!-- Include SweetAlert CSS and JS files -->
	<style>
        .btn-group .btn {
            margin-right: 7px; /* ปรับระยะห่างระหว่างปุ่ม */
        }
		body {
            font-family: 'Sarabun', sans-serif;
        }
		.profile-pic {
        display: flex;
        vertical-align: middle;
        width: 45px; /* ปรับขนาดตามต้องการ */
        height: 45px; /* ปรับขนาดตามต้องการ */
        overflow: hidden;
        border-radius: 50%;
		}

		.profile-pic img {
			width: 45px;
			height: 45px;
			object-fit: cover;
		}
		#logoutBtn {
			cursor: pointer;
		}
		.nav-link.dropdown-toggle::after {
			display: none;
		}
		.example-image:hover > div {
			opacity: 0.8;
			background-color: #000;
		}
    </style>

	<script>
	// สร้างฟังก์ชั่นเพื่อดึงข้อมูล
	function getData() {
		// ทำ HTTP request เพื่อดึงข้อมูลจาก ID Reader
		axios.get('http://localhost:5000/')
			.then(function (response) {
				// เมื่อรับข้อมูลสำเร็จ
				var result = response.data;

				if (result.Status === 902 || result.Status === 901) {
					// กรณีเกิดข้อผิดพลาด
					// alert('Error: ' + result.Message);
					Swal.fire({
						icon: "error",
						title: "Error : " + result.Status,
						text: result.Message,
						showConfirmButton: false,
						timer: 1500
					});
				} else if (result.Status === 200) {
					// กรณีที่ปกติ
					document.querySelector('input[name="c_idnumber"]').value = result['ID Number'];
					document.querySelector('input[name="c_thname"]').value = result['Thai Name'];
					document.querySelector('input[name="c_enname"]').value = result['English Name'];
					document.querySelector('input[name="c_gender"]').value = result['Gender'];
					document.querySelector('input[name="c_dob"]').value = result['Date of Birth'];
					document.querySelector('input[name="c_religion"]').value = result['Religion'];
					document.querySelector('input[name="c_address"]').value = result['Address'];
					document.querySelector('input[name="c_issuer"]').value = result['Issuer'];
					document.querySelector('input[name="c_doi"]').value = result['Date of Issue'];
					document.querySelector('input[name="c_doe"]').value = result['Date of Expiry'];
					document.querySelector('input[name="c_photo_base64"]').value = result['Photo(base64)'];
				}
			})
			.catch(function (error) {
            // กรณีเกิดข้อผิดพลาดในการรับข้อมูล
            // console.error('Error fetching data from ID Reader:', error);

            // แสดง Message Box
				Swal.fire({
						icon: "error",
						title: "Error : 903",
						text: "ระบบไม่พบโปรแกรมอ่านบัตรประชาชน",
						showConfirmButton: false,
						timer: 2500
					});
        		});
		}
		//ลบแบบ AJAX+SweetAlert2
		$(document).on('click', '.delete-member', function (e) {
			e.preventDefault();

			var memberId = $(this).data('id');

				Swal.fire({
					title: 'ต้องการลบรายการนี้ใช่หรือไม่?',
					text: 'รายการลำดับที่ ' + memberId + ' จะถูกลบ!',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#3085d6',
					confirmButtonText: 'ยืนยัน',
					cancelButtonText: 'ยกเลิก'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
						url: '<?php echo site_url("insertdata/delete_member"); ?>',
						type: 'POST',
						data: { id: memberId },
						dataType: 'json',
						success: function (response) {
							if (response.success) {
								Swal.fire({
									icon: 'success',
									title: 'ลบสำเร็จ',
									text: response.message,
									showConfirmButton: false,
									timer: 2500
								});

								// เรียกใช้ฟังก์ชันเพื่ออัปเดตตาราง
								updateMemberTable();
							} else {
								Swal.fire({
									icon: 'error',
									title: 'ลบไม่สำเร็จ',
									text: response.message,
									showConfirmButton: false,
									timer: 2500
								});
							}
						},
						error: function () {
							console.log('Error deleting member');
							}
						});
					}
				});
			});

			function addMember() {
				// ตรวจสอบว่ามีการใส่ข้อมูลใน ID Number หรือไม่
				var idNumber = $('input[name="c_idnumber"]').val();
				if (idNumber === '') {
					Swal.fire({
						icon: 'error',
						title: 'กรุณาใส่ข้อมูลให้ครบถ้วน',
						text: "ไม่พบข้อมูลเลขบัตรประชาชนในฟอร์มข้อมูล",
						showConfirmButton: false,
						timer: 1300
					});
					return; // ไม่ทำขั้นตอนถัดไปถ้าไม่ได้ใส่ ID Number
				}

				// ทำ HTTP request เพื่อบันทึกข้อมูลผ่าน Ajax
				$.ajax({
					url: '<?php echo site_url("insertdata/addmember_ajax"); ?>',
					type: 'POST',
					data: $('form').serialize(),
					dataType: 'json',
					success: function (response) {
						if (response.success) {
							Swal.fire({
								icon: 'success',
								title: 'บันทึกสำเร็จ',
								text: response.message,
								showConfirmButton: false,
								timer: 2500
							});
							updateMemberTable();
							document.getElementById("addmember_form01").reset();
							$('form')[0].reset();
						} else {
							Swal.fire({
								icon: 'error',
								title: 'บันทึกไม่สำเร็จ',
								text: response.message,
								showConfirmButton: false,
								timer: 2500
							});
							document.getElementById("addmember_form01").reset();
						}
					},
					error: function () {
						Swal.fire({
							icon: 'error',
							title: 'เกิดข้อผิดพลาดในการส่งข้อมูล',
							text: 'กรุณาลองใหม่อีกครั้ง',
							showConfirmButton: false,
							timer: 2500
						});
					}
				});
			}
                        //update ajax member_view.php
		function updateMemberTable() {
			$.ajax({
				url: '<?php echo site_url("insertdata/get_member_data"); ?>',
				type: 'GET',
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						// ลบข้อมูลเก่าทั้งหมดในตาราง
						$('tbody').empty();

						// วนลูปเพื่อเพิ่มข้อมูลใหม่
						$.each(response.data, function (index, rs) {
							var newRow = '<tr>' +
								'<td>' + rs.c_id + '</td>' +
								'<td>' + rs.c_idnumber + '</td>' +
								'<td>' + rs.c_thname + '</td>' +
								'<td><img src="data:image/jpeg;base64,' + rs.c_photo_base64 + '" alt="Photo" style="max-width: 100px; max-height: 100px;"></td>' +
								
								'<td><div class="btn-group">' +
								'<a href="<?php echo site_url('insertdata/edit/'); ?>' + rs.c_id + '" class="btn btn-info rounded"><i class="fas fa-pencil-alt" style="font-size: 14px;"></i></a>' +
								'<a class="btn btn-danger delete-member rounded" data-id="' + rs.c_id + '"><i class="fas fa-trash-alt" style="font-size: 14px;"></i></a>' +
								'<a class="btn btn-primary rounded" onclick="showPopupMember(' + rs.c_id + ')"><i class="fas fa-eye" style="font-size: 13px;"></i></a>' +
								'</div></td>'+

								
								'</tr>';
							$('tbody').append(newRow);
						});
					} else {
						console.log(response.message);
					}
					
				},
				error: function () {
					console.log('Error fetching data');
				}
			});
		}
		function editMember() {
			// ทำ HTTP request เพื่อบันทึกข้อมูลผ่าน Ajax
			$.ajax({
				url: '<?php echo site_url("Insertdata/editing_ajax"); ?>',
				type: 'POST',
				data: $('form').serialize(),
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						Swal.fire({
							icon: 'success',
							title: 'แก้ไขสำเร็จ',
							text: 'ข้อมูลถูกแก้ไขเรียบร้อยแล้ว',
							showConfirmButton: false,
							timer: 2500
							
						}).then((result) => {
                                // Redirect หน้าไปที่หน้าหลักหลังจากแจ้งเตือน
                                window.location.href = '<?php echo site_url("admin/idcard_management"); ?>';
                            });
					} else {
						Swal.fire({
							icon: 'error',
							title: 'แก้ไขไม่สำเร็จ',
							text: 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล',
							showConfirmButton: false,
							timer: 2500
						});
					}
				},
				error: function () {
					Swal.fire({
						icon: 'error',
						title: 'เกิดข้อผิดพลาดในการส่งข้อมูล',
						text: 'กรุณาลองใหม่อีกครั้ง',
						showConfirmButton: false,
						timer: 2500
					});
				}
			});
    	}
		function showPopupMember(memberId) {
			
			
		// ทำ AJAX เพื่อดึงข้อมูลสมาชิกจาก API
		$.ajax({
			url: '<?php echo site_url("insertdata/get_member_data"); ?>',
			type: 'GET',
			dataType: 'json',
			success: function (response) {
				if (response.success) {
					// หาข้อมูลสมาชิกที่ตรงกับ memberId
					var memberData = response.data.find(function (member) {
						return member.c_id == memberId;
					});

					// แสดงป๊อปอัพด้วย SweetAlert2
					Swal.fire({
						title: 'ข้อมูลสมาชิก',
						html: generatePopupContent(memberData),
						customClass: {
                        popup: 'custom-swal-popup', // กำหนดคลาส CSS สำหรับ popup
                    },
                    width: '50%', // กำหนดความกว้างของ popup
					});
					
				} else {
					console.log(response.message);
				}
			},
			error: function () {
				console.log('เกิดข้อผิดพลาดในการดึงข้อมูล');
			}
		});
	}

	// ฟังก์ชันสำหรับสร้างเนื้อหาในป๊อปอัพ
	function generatePopupContent(memberData) {
		var photoHtml = memberData.c_photo_base64 ?
        '<img src="data:image/jpeg;base64,' + memberData.c_photo_base64 + '" alt="Photo" align="right" style="max-width: 150px; max-height: 150px; vertical-align: top;">' :
        '<p><strong>รูปภาพ:</strong> ไม่มีข้อมูลรูปภาพ</p>';

    return '<div style="text-align: left;">' +
		photoHtml +
        '<p><strong>ID:</strong> ' + memberData.c_id + '</p>' +
        '<p><strong>ID Number:</strong> ' + memberData.c_idnumber + '</p>' +
        '<p><strong>ชื่อ-นามสกุล (ไทย):</strong> ' + memberData.c_thname + '</p>' +
        '<p><strong>ชื่อ-นามสกุล (อังกฤษ):</strong> ' + memberData.c_enname + '</p>' +
        '<p><strong>เพศ:</strong> ' + memberData.c_gender + '</p>' +
        '<p><strong>วันเกิด:</strong> ' + memberData.c_dob + '</p>' +
        '<p><strong>ศาสนา:</strong> ' + memberData.c_religion + '</p>' +
        '<p><strong>ที่อยู่:</strong> ' + memberData.c_address + '</p>' +
        '<p><strong>ผู้ออกบัตร:</strong> ' + memberData.c_issuer + '</p>' +
        '<p><strong>วันออกบัตร:</strong> ' + memberData.c_doi + '</p>' +
        '<p><strong>วันออกบัตร:</strong> ' + memberData.c_doe + '</p>' 
         // แทรกรูปภาพ
        // เพิ่มข้อมูลอื่น ๆ ตามต้องการ
        '</div>';
	}
	$(document).ready(function () {
        // ฟังก์ชันกรองข้อมูล
        $("#searchInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            // ให้ตารางซ่อนแถวที่ไม่ตรงกับคำค้นหา
            $("tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });


	//user
	//logout


	function addUser() {
    // Create FormData object from the form with id 'adduser_form01'
    var formData = new FormData($('#adduser_form01')[0]);

    // Make the Ajax request
    $.ajax({
        url: "<?php echo site_url('admin/user_management/adduser_ajax'); ?>",
        type: "POST",
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting contentType
        dataType: "json", // Specify the expected data type
        success: function (response) {
            if (response.status === 'success') {
                // If the response status is 'success', show a success message
                Swal.fire({
                    icon: 'success',
                    title: 'บันทึกข้อมูลสำเร็จ',
                    showConfirmButton: false,
                    timer: 1500
                });

                // Call a function to update the user table (assuming you have such a function)
                updateUserTable();

                // Reset the form
                $('#adduser_form01')[0].reset();
				
            } else {
                // If the response status is not 'success', show an error message
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });

                // Reset the form
                $('#adduser_form01')[0].reset();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle any errors that occur during the Ajax request
            console.error('Ajax request failed:', textStatus, errorThrown);

            // Optionally, show an error message to the user
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'พบข้อผิดพลาดในการส่งข้อมูล',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

	function updateUserTable() {
			$.ajax({
				url: '<?php echo site_url("user/central_management/get_user_data"); ?>',
				type: 'GET',
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						// ลบข้อมูลเก่าทั้งหมดในตาราง
						$('tbody').empty();

						// วนลูปเพื่อเพิ่มข้อมูลใหม่
						$.each(response.data, function (index, rs) {
							var newRow = '<tr>' +
								'<td>' + rs.u_id + '</td>' +
								'<td>' + rs.pname + '</td>' +
								'<td>' + rs.u_fname + '</td>' +
								'<td>' + rs.u_lname + '</td>' +

								'<td><div class="btn-group">' +
								'<a href="<?php echo site_url('admin/user_management/user_edit/'); ?>' + rs.u_id + '" class="btn btn-info rounded"><i class="fas fa-pencil-alt" style="font-size: 14px;"></i></a>' +
								'<a class="btn btn-primary rounded" onclick="showPopupUser(' + rs.u_id + ')"><i class="fas fa-eye" style="font-size: 13px;"></i></a>' +
								'<a class="btn btn-warning rounded" onclick="resetPassword(' + rs.u_id + ')"><i class="fas fa-rotate-left" style="font-size: 14px;"></i></a>' +
								'<a class="btn btn-danger delete-user rounded" data-id="' + rs.u_id + '"><i class="fas fa-trash-alt" style="font-size: 14px;"></i></a>'+
								'</div></td>'+
								'</tr>';
							$('tbody').append(newRow);
						});
					} else {
						console.log(response.message);
					}
				},
				error: function () {
					console.log('Error fetching data');
				}
			});
		}
		$(document).on('click', '.delete-user', function (e) {
			e.preventDefault();

			var userId = $(this).data('id');

				Swal.fire({
					title: 'ต้องการลบผู้ใช้งานนี้ใช่หรือไม่?',
					text: 'ผู้ใช้งานลำดับที่ ' + userId + ' จะถูกลบ!',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#3085d6',
					confirmButtonText: 'ยืนยัน',
					cancelButtonText: 'ยกเลิก'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
						url: '<?php echo site_url("admin/user_management/delete_user"); ?>',
						type: 'POST',
						data: { id: userId },
						dataType: 'json',
						success: function (response) {
							if (response.success) {
								Swal.fire({
									icon: 'success',
									title: 'ลบสำเร็จ',
									text: response.message,
									showConfirmButton: false,
									timer: 2500
								});

								// เรียกใช้ฟังก์ชันเพื่ออัปเดตตาราง
								updateUserTable();
							} else {
								Swal.fire({
									icon: 'error',
									title: 'ลบไม่สำเร็จ',
									text: response.message,
									showConfirmButton: false,
									timer: 2500
								});
							}
						},
						error: function () {
							console.log('Error deleting member');
							}
						});
					}
				});
			});

			function editUser() {
			// ทำ HTTP request เพื่อบันทึกข้อมูลผ่าน Ajax
			$.ajax({
				url: '<?php echo site_url("user/central_management/editing_ajax"); ?>',
				type: 'POST',
				data: $('form').serialize(),
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						Swal.fire({
							icon: 'success',
							title: 'แก้ไขสำเร็จ',
							text: 'ข้อมูลถูกแก้ไขเรียบร้อยแล้ว',
							showConfirmButton: false,
							timer: 2500
							
						}).then((result) => {
                                // Redirect หน้าไปที่หน้าหลักหลังจากแจ้งเตือน
                                window.location.href = '<?php echo site_url("user/central_management/path_finding"); ?>';
                            });
					} else {
						Swal.fire({
							icon: 'error',
							title: 'แก้ไขไม่สำเร็จ',
							text: 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล',
							showConfirmButton: false,
							timer: 2500
						});
					}
				},
				error: function () {
					Swal.fire({
						icon: 'error',
						title: 'เกิดข้อผิดพลาดในการส่งข้อมูล',
						text: 'กรุณาลองใหม่อีกครั้ง',
						showConfirmButton: false,
						timer: 2500
					});
				}
			});
    	}
		
		function editProfile() {
			// สร้าง FormData object เพื่อเก็บข้อมูลฟอร์ม
			var formData = new FormData($('form')[0]);

			// ทำ HTTP request เพื่อบันทึกข้อมูลผ่าน Ajax
			$.ajax({
				url: '<?php echo site_url("user/central_management/uploading_profile"); ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				contentType: false,
				processData: false,
				success: function(response) {
					if (response.success) {
						Swal.fire({
							icon: 'success',
							title: 'แก้ไขสำเร็จ',
							text: 'ข้อมูลถูกแก้ไขเรียบร้อยแล้ว',
							showConfirmButton: false,
							timer: 2500
						}).then((result) => {
							// Redirect หน้าไปที่หน้าหลักหลังจากแจ้งเตือน
							window.location.href = '<?php echo site_url("user/central_management/path_finding"); ?>';
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'แก้ไขไม่สำเร็จ',
							text: 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล',
							showConfirmButton: false,
							timer: 2500
						});
					}
				},
				error: function() {
					Swal.fire({
						icon: 'error',
						title: 'เกิดข้อผิดพลาดในการส่งข้อมูล',
						text: 'กรุณาลองใหม่อีกครั้ง',
						showConfirmButton: false,
						timer: 2500
					});
				}
			});
		}

		function resetPassword(userId) {
		Swal.fire({
			title: 'รีเซ็ตรหัสผ่านผู้ใช้งาน ['+ userId +'] หรือไม่?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'ตกลง',
			cancelButtonText: 'ยกเลิก'
		}).then((result) => {
			if (result.isConfirmed) {
				// ทำการเรียก Ajax เพื่อรีเซ็ตรหัสผ่าน
				$.ajax({
					url: '<?php echo site_url("admin/user_management/reset_password/"); ?>' + userId,
					type: 'GET',
					dataType: 'json',
					success: function(response) {
						if (response.status === 'success') {
							Swal.fire({
								title: 'รหัสผ่านถูกรีเซ็ต',
								text: 'รหัสผ่านถูกรีเซ็ตเป็น 123456',
								icon: 'success',
								showConfirmButton: false,
								timer: 2500
							});
							updateUserTable();
						} else {
							Swal.fire({
								title: 'ผิดพลาด',
								text: response.message,
								icon: 'error',
								showConfirmButton: false,
								timer: 1500
							});
						}
					},
					error: function() {
						Swal.fire({
							title: 'ผิดพลาด',
							text: 'เกิดข้อผิดพลาดในการเรียกใช้งาน',
							icon: 'error',
							showConfirmButton: false,
							timer: 1500
						});
					}
				});
			}
		});
	}
	function showPopupUser(userId) {
			
			
			// ทำ AJAX เพื่อดึงข้อมูลสมาชิกจาก API
			$.ajax({
				url: '<?php echo site_url("user/central_management/get_user_data"); ?>',
				type: 'GET',
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						// หาข้อมูลสมาชิกที่ตรงกับ userId
						var userData = response.data.find(function (user) {
							return user.u_id == userId;
						});
	
						// แสดงป๊อปอัพด้วย SweetAlert2
						Swal.fire({
							title: 'ข้อมูลผู้ใช้งาน',
							html: generatePopupUserContent(userData),
							customClass: {
							popup: 'custom-swal-popup', // กำหนดคลาส CSS สำหรับ popup
						},
						width: '40%', // กำหนดความกว้างของ popup
						});
						
					} else {
						console.log(response.message);
					}
				},
				error: function () {
					console.log('เกิดข้อผิดพลาดในการดึงข้อมูล');
				}
			});
		}
	
		// ฟังก์ชันสำหรับสร้างเนื้อหาในป๊อปอัพ
		function generatePopupUserContent(userData) {
			var photoHtml = userData.u_img ?
			'<img src="' + '<?php echo base_url('img/'); ?>' + userData.u_img + '" alt="Photo" align="right" style="width: 100px; height: 100px; object-fit: cover; object-position: center center; border-radius: 50%;">' :
			'<img src="' + '<?php echo base_url('img/blankuser.jpg'); ?>' + '" alt="Blank Photo" align="right" style="width: 100px; height: 100px; object-fit: cover; object-position: center center; border-radius: 50%;">';

			
			// ต่อไปนี้เป็นโค้ดอื่น ๆ ที่คุณอาจมี
			// ...

			// คืนค่า HTML ทั้งหมด
			return '<div style="text-align: left;">' +
				photoHtml +
				'<p><strong>UID:</strong> ' + userData.u_id + '</p>' +
				'<p><strong>Level:</strong> ' + userData.pname + '</p>' +
				'<p><strong>Username : </strong> ' + userData.u_username + '</p>' +
				'<p><strong>Firstname : </strong> ' + userData.u_fname + '</p>' +
				'<p><strong>Lastname : </strong> ' + userData.u_lname + '</p>' +
				'<p><strong>Email : </strong> ' + userData.u_email + '</p>' +
				'<p><strong>Register Date : </strong> ' + userData.u_datesave + '</p>' 
				// แทรกรูปภาพ
				// เพิ่มข้อมูลอื่น ๆ ตามต้องการ
				'</div>';
		}
		document.querySelectorAll('.dropdown-toggle').forEach(item => {
        item.addEventListener('click', event => {
            if (event.target.classList.contains('dropdown-toggle')) {
                event.target.classList.toggle('toggle-change');
            } else if (event.target.parentElement.classList.contains('dropdown-toggle')) {
                event.target.parentElement.classList.toggle('toggle-change');
            }
        });
    });
	
	</script>
	
</head>
<body>