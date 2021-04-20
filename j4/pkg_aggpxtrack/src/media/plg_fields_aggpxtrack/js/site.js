document.addEventListener('DOMContentLoaded', function () {
	var aggpxtrackactivate = document.querySelectorAll('.aggpxtrackactivate');
	[].forEach.call(aggpxtrackactivate, function (element) {
		element.addEventListener("click", function (e) {
			var curr_page = window.location.href;
			var next_page = "";

			if (curr_page.indexOf("?") > -1) {
				next_page = curr_page + "&aggpxtrackshow=1";
			} else {
				next_page = curr_page + "?aggpxtrackshow=1";
			}

			window.location = next_page;
		});
	});

	var aggpxtrackdeactivate = document.querySelectorAll('.aggpxtrackdeactivate');
	[].forEach.call(aggpxtrackdeactivate, function (element) {

		element.addEventListener("click", function (e) {
			var curr_page = window.location.href;
			var next_page = "";

			next_page = curr_page.replace("&aggpxtrackshow=1", "").replace("?aggpxtrackshow=1", "");

			window.location = next_page;
		});
	});
}, false);
