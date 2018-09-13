function hideControlsLower(id, value) {
	document.getElementById("controls-" + (id + 3)).style.visibility = value;
}

function updateProjectDropdown(id, parent) {
	var sel = document.getElementById(id);

	$.get(
		"http://127.0.0.1/portfolio/files/include/ajax/getProjectsFromCategory.php?category=" +
			parent.value,
		function(response) {
			if (response == "") {
				sel.innerHTML = "";
				return;
			}
			var data = response.split(",");

			for (var i = 0; i < data.length; i++) {
				var split = data[i].split(":");
				var id = split[0];
				var name = split[1];

				sel.innerHTML = "<option value='" + id + "'>" + name + "</option>";
			}
		}
	);
}

function updateHighlightSlot(id, parent) {
	var project = document.getElementById("projectDropdown-" + id);
	var text = project.options[project.selectedIndex].text;
	var value = project.options[project.selectedIndex].value;

	var displayName = document.getElementById("projectName-" + id);
	displayName.innerHTML = text;

	var row = parent.dataset.row;
	var column = parent.dataset.column;

	$.post(
		"http://127.0.0.1/portfolio/files/include/ajax/changeHighlightMatrix.php",
		{
			row: parseInt(row) + 1,
			column: column,
			id: value
		},
		function(response) {
			if (response === "ERROR") {
				console.log("An error has occured in updating highlighted projects");
			}
		}
	);
}

function removeHighlight(id, parent) {
	var row = parent.dataset.row;
	var column = parent.dataset.column;

	$.post(
		"http://127.0.0.1/portfolio/files/include/ajax/changeHighlightMatrix.php",
		{
			row: parseInt(row) + 1,
			column: column,
			id: "NULL"
		},
		function(response) {
			if (response === "ERROR") {
				console.log("An error has occured in updating highlighted projects");
			}
		}
	);

	var displayName = document.getElementById("projectName-" + id);
	displayName.innerHTML = "None";
}

function showPopup(type) {
	if (type == "category") {
		document.getElementById("category-popup").style.visibility = "visible";
		document.getElementById("category-popup").style.animation = "fadeIn 0.6s";
	} else if (type == "addUser") {
		document.getElementById("addUser-popup").style.visibility = "visible";
		document.getElementById("addUser-popup").style.animation = "fadeIn 0.6s";
	} else if (type == "addProject") {
		document.getElementById("addProject-popup").style.visibility = "visible";
		document.getElementById("addProject-popup").style.animation = "fadeIn 0.6s";
	} else if (type == "editProject") {
		document.getElementById("editProject-popup").style.visibility = "visible";
		document.getElementById("editProject-popup").style.animation = "fadeIn 0.6s";
	}

	document.getElementById("fade").style.visibility = "visible";
	document.getElementById("fade").style.animation = "blackFadeIn 0.6s";
}

function closePopup(type) {
	if (type == "category") {
		document.getElementById("category-popup").style.animation = "fadeOut 1s";
		setTimeout(function() {
			document.getElementById("category-popup").style.visibility = "hidden";
		}, 1000);
	} else if (type == "addUser") {
		document.getElementById("addUser-popup").style.animation = "fadeOut 1s";
		setTimeout(function() {
			document.getElementById("addUser-popup").style.visibility = "hidden";
		}, 1000);
	} else if (type == "addProject") {
		document.getElementById("addProject-popup").style.animation = "fadeOut 1s";
		setTimeout(function() {
			document.getElementById("addProject-popup").style.visibility = "hidden";
		}, 1000);
	} else if (type == "editProject") {
		document.getElementById("editProject-popup").style.animation = "fadeOut 1s";
		setTimeout(function() {
			document.getElementById("editProject-popup").style.visibility = "hidden";
		}, 1000);
	}

	document.getElementById("fade").style.animation = "blackFadeOut 1s";
	setTimeout(function() {
		document.getElementById("fade").style.visibility = "hidden";
	}, 1000);
}

function deleteUser(id) {
	swal({
		title: "Are you sure?",
		text: "You won't be able to revert this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#d33",
		cancelButtonColor: "#3085d6",
		confirmButtonText: "Yes, delete it!"
	}).then(result => {
		if (result.value) {
			sendPost("../admin/admin.php", { deleteUser: "true", ID: id });
		}
	});
}

function deleteCategory(id) {
	swal({
		title: "Are you sure?",
		text: "You won't be able to revert this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#d33",
		cancelButtonColor: "#3085d6",
		confirmButtonText: "Yes, delete it!"
	}).then(result => {
		if (result.value) {
			sendPost("../admin/admin.php", { deleteCategory: "true", ID: id });
		}
	});
}

function deleteProject(id, uid) {
	swal({
		title: "Are you sure?",
		text: "You won't be able to revert this!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#d33",
		cancelButtonColor: "#3085d6",
		confirmButtonText: "Yes, delete it!"
	}).then(result => {
		if (result.value) {
			sendPost("../admin/admin.php", { deleteProject: "true", ID: id, Folder: uid });
		}
	});
}

function sendPost(path, params) {
	var form = document.createElement("form");
	form.setAttribute("method", "post");
	form.setAttribute("action", path);

	for (var key in params) {
		if (params.hasOwnProperty(key)) {
			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", key);
			hiddenField.setAttribute("value", params[key]);

			form.appendChild(hiddenField);
		}
	}

	document.body.appendChild(form);
	form.submit();
}

function escListener(e) {
	if (e.keyCode != 27) return;

	var cat = document.getElementById("category-popup");
	var user = document.getElementById("addUser-popup");
	var project = document.getElementById("addProject-popup");
	var editProject = document.getElementById("editProject-popup");
	var overlay = document.getElementById("fade");

	if (cat.style.visibility == "visible") {
		cat.style.animation = "fadeOut 1s";
		setTimeout(function() {
			cat.style.visibility = "hidden";
		}, 1000);
	} else if (user.style.visibility == "visible") {
		user.style.animation = "fadeOut 1s";
		setTimeout(function() {
			user.style.visibility = "hidden";
		}, 1000);
	} else if (project.style.visible == "visible") {
		project.style.animation = "fadeOut 1s";
		setTimeout(function() {
			project.style.visibility = "hidden";
		}, 1000);
	} else if (editProject.style.visible == "visible") {
		editProject.style.animation = "fadeOut 1s";
		setTimeout(function() {
			editProject.style.visibility = "hidden";
		}, 1000);
	}

	if (overlay.style.visibility == "visible") {
		overlay.style.animation = "blackFadeOut 1s";
		setTimeout(function() {
			overlay.style.visibility = "hidden";
		}, 1000);
	}
}
