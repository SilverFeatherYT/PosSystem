// Show the submenu
let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
	arrow[i].addEventListener("click", (e) => {
		let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
		arrowParent.classList.toggle("showMenu");
	});
}


// Open and close the sidebar
// Open and close the sidebar
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");

sidebarBtn.addEventListener("click", () => {
	sidebar.classList.toggle("close");
	const sidebarStatus = sidebar.classList.contains("close") ? "closed" : "open";
	localStorage.setItem("sidebarStatus", sidebarStatus); // Store sidebar status in localStorage
});

// Function to toggle sidebar based on window width
function toggleSidebar() {
	if (window.innerWidth <= 769) {
		sidebar.classList.add('close');
	} else {
		sidebar.classList.remove('close');
	}
}

// Initial check on page load
toggleSidebar();

// Check on window resize
window.addEventListener('resize', toggleSidebar);

// Check sidebar status in localStorage and apply it on page load
const storedSidebarStatus = localStorage.getItem("sidebarStatus");
if (storedSidebarStatus === "closed") {
	sidebar.classList.add("close");
}



// window.addEventListener('DOMContentLoaded', function () {
// 	function toggleSidebar() {
// 		if (window.innerWidth <= 769) {
// 			sidebar.classList.add('close');
// 		} else {
// 			sidebar.classList.remove('close');
// 		}
// 	}

// 	// Initial check on page load
// 	toggleSidebar();

// 	// Check on window resize
// 	window.addEventListener('resize', toggleSidebar);
// });




const switchMode = document.getElementById("switch-mode");

switchMode.addEventListener("change", function () {
	if (this.checked) {
		document.body.classList.add("dark");
		localStorage.setItem("darkMode", "true"); // Store dark mode status in localStorage
	} else {
		document.body.classList.remove("dark");
		localStorage.setItem("darkMode", "false"); // Store dark mode status in localStorage
	}
});

// Check if dark mode status is stored in localStorage and apply it on page load
window.addEventListener("DOMContentLoaded", function () {
	const darkMode = localStorage.getItem("darkMode");
	if (darkMode === "true") {
		document.body.classList.add("dark");
		switchMode.checked = true;
	}
});
