const fileInput = document.querySelector('.upload-btn');
const imageElement = document.getElementById('pro_Photo');




imageElement.addEventListener('click', () => fileInput.click());
fileInput.addEventListener('change', function () {

	if (fileInput.files && fileInput.files[0]) {
		var reader = new FileReader(); //이미지 파일 읽기
		reader.onload = function (e) {
			let dataURL = e.target.result;
			imageElement.src = dataURL;
		};
		reader.readAsDataURL(fileInput.files[0]);
	}
});

function checkPWD() {
	const pwd = document.getElementsByName("pwd")[0];
	const confirm_pwd = document.getElementsByName("confirm_pwd")[0];
	const warning = document.getElementById('checkPWD');

	if (!(pwd.value === confirm_pwd.value)) {
		warning.innerHTML = "!!!비밀번호가 다릅니다!!!";
		warning.style.display = "";
	} else {
		warning.innerHTML = "";
		warning.style.display = "none";
	}
}

