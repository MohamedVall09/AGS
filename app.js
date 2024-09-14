const iconCart = document.querySelector('.iconCart');
const cart = document.querySelector('.cart');
const container = document.querySelector('.container');
const close = document.querySelector('.close');

const profile = document.getElementById("profile");
const iconUser = document.getElementById("iconUser");


const cash = document.getElementById("cash");
const iconX = document.getElementById("iconX");
const confirmOrder = document.getElementById("confirmOrder");



iconCart.addEventListener('click', function(){
    if(cart.style.right === '-100%'){
        cart.style.right = '0';
        container.classList.add("container-");
    }else{
        cart.style.right = '-100%';
        container.classList.remove("container-");
    }
})
iconUser.addEventListener("click", function(){
	if (profile.style.display === 'none') {
		profile.style.display = "block";
	}else{
		profile.style.display = "none";
	};
});
iconX.addEventListener('click', function(){
    cash.style.display = "none";
    confirmOrder.style.display = "none";
});

// addItem.addEventListener('click', function(){
//     window.location.reload();
//     console.log(5);
// });


// let products = null;
// // get data from file json
// fetch('product.json')
//     .then(response => response.json())
//     .then(data => {
//         products = data;
//         addDataToHTML();
// })

// //show datas product in list 
// function addDataToHTML(){
//     // remove datas default from HTML
//     let listProductHTML = document.querySelector('.listProduct');
//     listProductHTML.innerHTML = '';

//     // add new datas
//     if(products != null) // if has data
//     {
//         products.forEach(product => {
//             let newProduct = document.createElement('div');
//             newProduct.classList.add('item');
//             newProduct.innerHTML = 
//             `<img src="${product.image}" alt="">
//             <h2>${product.name}</h2>
//             <div class="price">$${product.price}</div>
//             <button onclick="addCart(${product.id})">Add To Cart</button>`;

//             listProductHTML.appendChild(newProduct);

//         });
//     }
// }
// //use cookie so the cart doesn't get lost on refresh page


// let listCart = [];
// function checkCart(){
//     var cookieValue = document.cookie
//     .split('; ')
//     .find(row => row.startsWith('listCart='));
//     if(cookieValue){
//         listCart = JSON.parse(cookieValue.split('=')[1]);
//     }else{
//         listCart = [];
//     }
// }
// checkCart();
// function addCart($idProduct){
//     let productsCopy = JSON.parse(JSON.stringify(products));
//     //// If this product is not in the cart
//     if(!listCart[$idProduct]) 
//     {
//         listCart[$idProduct] = productsCopy.filter(product => product.id == $idProduct)[0];
//         listCart[$idProduct].quantity = 1;
//     }else{
//         //If this product is already in the cart.
//         //I just increased the quantity
//         listCart[$idProduct].quantity++;
//     }
//     document.cookie = "listCart=" + JSON.stringify(listCart) + "; expires=Thu, 31 Dec 2025 23:59:59 UTC; path=/;";

//     addCartToHTML();
// }
// addCartToHTML();
// function addCartToHTML(){
//     // clear data default
//     let listCartHTML = document.querySelector('.listCart');
//     listCartHTML.innerHTML = '';

//     let totalHTML = document.querySelector('.totalQuantity');
//     let totalQuantity = 0;
//     // if has product in Cart
//     if(listCart){
//         listCart.forEach(product => {
//             if(product){
//                 let newCart = document.createElement('div');
//                 newCart.classList.add('item');
//                 newCart.innerHTML = 
//                     `<img src="${product.image}">
//                     <div class="content">
//                         <div class="name">${product.name}</div>
//                         <div class="price">$${product.price} / 1 product</div>
//                     </div>
//                     <div class="quantity">
//                         <button onclick="changeQuantity(${product.id}, '-')">-</button>
//                         <span class="value">${product.quantity}</span>
//                         <button onclick="changeQuantity(${product.id}, '+')">+</button>
//                     </div>`;
//                 listCartHTML.appendChild(newCart);
//                 totalQuantity = totalQuantity + product.quantity;
//             }
//         })
//     }
//     totalHTML.innerText = totalQuantity;
// }
// function changeQuantity($idProduct, $type){
//     switch ($type) {
//         case '+':
//             listCart[$idProduct].quantity++;
//             break;
//         case '-':
//             listCart[$idProduct].quantity--;

//             // if quantity <= 0 then remove product in cart
//             if(listCart[$idProduct].quantity <= 0){
//                 delete listCart[$idProduct];
//             }
//             break;
    
//         default:
//             break;
//     }
//     // save new data in cookie
//     document.cookie = "listCart=" + JSON.stringify(listCart) + "; expires=Thu, 31 Dec 2025 23:59:59 UTC; path=/;";
//     // reload html view cart
//     addCartToHTML();
// }
