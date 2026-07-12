
let products =
JSON.parse(localStorage.getItem("products")) || [];



// LOGIN

function login(){

let email=document.getElementById("email").value;

let password=document.getElementById("password").value;


if(email && password){

localStorage.setItem(
"login",
"true"
);


location="dashboard.html";

}

else{

alert("Enter details");

}

}



// ADD PRODUCT

function addProduct(){


let title=document.getElementById("title").value;


let file=document.getElementById("image").files[0];


let image="";


if(file)
{

image=URL.createObjectURL(file);

}



products.push({

id:Date.now(),

title:title,

image:image

});


localStorage.setItem(
"products",
JSON.stringify(products)
);


showProducts();


}



// READ + SEARCH

function showProducts(){


let search=document.getElementById("search")?.value
.toLowerCase() || "";


let output="";


products
.filter(p=>p.title.toLowerCase()
.includes(search))
.forEach(p=>{


output+=`

<div class="col-md-4">

<div class="card shadow p-3 mt-3">


<img src="${p.image}"
height="150">


<h4>
${p.title}
</h4>


<button class="btn btn-danger"
onclick="deleteProduct(${p.id})">

Delete

</button>


</div>

</div>

`;


});


document.getElementById("list").innerHTML=output;


}




// DELETE

function deleteProduct(id){


products=
products.filter(p=>p.id!=id);


localStorage.setItem(
"products",
JSON.stringify(products)
);


showProducts();

}



// LOGOUT

function logout(){

localStorage.removeItem("login");

location="index.html";

}


showProducts();
