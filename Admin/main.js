// Retrieve the last hovered list item from localStorage
const lastHoveredIndex = localStorage.getItem("lastHoveredIndex");

// Add hovered class to the last hovered list item
if (lastHoveredIndex !== null) {
  const listItems = document.querySelectorAll(".navigation li");
  listItems[lastHoveredIndex].classList.add("hovered");
}

// add hovered class to selected list item
const list = document.querySelectorAll(".navigation li");
// Menu Toggle
const toggle = document.querySelector(".toggle");
const navigation = document.querySelector(".navigation");
const main = document.querySelector(".main");

function activeLink() {
  list.forEach((item, index) => {
    item.classList.remove("hovered");
    if (item === this) {
      // Save the index of the hovered list item to localStorage
      localStorage.setItem("lastHoveredIndex", index);
    }
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};

// From Toggle
const cash = document.getElementById("cash");
const iconX = document.getElementById("iconX");
const confirmOrder = document.getElementById("FormEdit");

iconX.addEventListener('click', function(){
  cash.style.display = "none";
  confirmOrder.style.display = "none";
});

// Find the input element by its ID
const imgInput = document.getElementById('imgInput');
const newImg = document.getElementById("newImg");

// Create a new image element
const productImage = document.createElement("img");

// Set attributes for the product image
productImage.id = "productImage";
productImage.style.display = "block"; // Make sure the image is visible

// Append the image element to the existing element with the ID "newImg"
newImg.appendChild(productImage);

// Add an event listener to the input field
imgInput.addEventListener('change', function() {
    // Check if a file is selected
    if (this.files && this.files[0]) {
        // Create a FileReader object
        const reader = new FileReader();

        // Set up the onload event handler
        reader.onload = function(e) {
            // Set the src attribute of the product image to the data URL of the selected file
            productImage.setAttribute("src", e.target.result);
        };
        // Read the selected file as a data URL
        reader.readAsDataURL(this.files[0]);
    }
});

