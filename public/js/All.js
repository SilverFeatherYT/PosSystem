// Focus input field function
const inputs = document.querySelectorAll(".input");

function addcl() {
  let parent = this.parentNode;
  parent.classList.add("focus");
}

function remcl() {
  let parent = this.parentNode;
  if (this.value == "") {
    parent.classList.remove("focus");
  }
}

inputs.forEach(input => {
  input.addEventListener("focus", addcl);
  input.addEventListener("blur", remcl);
});
// Focus input field function


