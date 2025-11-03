const themeToggleDarkIcon = document.getElementById("theme-toggle-icon");
const themeToggleBtn = document.getElementById("theme-toggle");

if(!("color-theme" in localStorage)){
    localStorage.setItem("color-theme", "light");
}

console.log('loaded');
themeToggleBtn.addEventListener("click", function () {
    const newMode = localStorage.getItem("color-theme") === "light" ? "dark" : "light";

    document.documentElement.classList.toggle("dark");

    themeToggleDarkIcon.classList.toggle("fill-[#fff]");
    localStorage.setItem("color-theme", newMode);
});
