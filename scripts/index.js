$(document).ready(() => {
	$("#add").click(() => {
		location.href = "add.php"
	})

	$("#logout").click(() => {
		document.cookie = "lid" + "=" + ";expires=Thu, 01 Jan 1970 00:00:01 GMT"
		location.href = "index.php"
	})

	$("#login").click(() => {
		location.href = "login.php"
	})

	$("#register").click(() => {
		location.href = "register.php"
	})
})
