"use strict"
const BASE_PATH = window.location.pathname.split("/").slice(0, -2).join("/"); // Ajusta el nivel según la estructura
const BASE_URL = `${window.location.origin}${BASE_PATH}/ThomWeb/api/`;

let btnInicio=document.getElementById("inicio").addEventListener("click", getAllVehicles);

let vehicle= {};
let Vehicles = [];

async function getAllVehicles() {
    try {
        const response= await fetch( BASE_URL + "vehicles");
       
        if(!response.ok){
            throw new Error("error al llamar get vehicles");
            
        }
       Vehicles= await response.json();
       showVehicles();
        
    } catch (error) {
        console.log(error);
    }
}

function showVehicles(){
    let div= document.getElementById("contenedorMostrar");
    div.innerHTML="";
    Vehicles.forEach(vehicle => {
    let html= ` <div class="col-md-4 mb-4">
                    <div class='card'>
                        <div class='film-image' style='height: 200px; background-color: #f0f0f0; border: 5px solid black;'>
                            <img src=${vehicle.imagen_Vehicle} alt=${vehicle.name} class='card-img-top' style='height: 100%; object-fit: cover;'>
                        </div>
                        <div class='card-body'>
                                <h5 class='card-title'>
                                    <a href='#' data-id='${vehicle.id_vehicle}'class='text-decoration-none titulo text-danger  btnDetail' >${vehicle.car_brand}</a>
                                </h5>
                                <p class='card-text'>${vehicle.price}</p>
                        </div>
                </div>
            </div>`;
     div.innerHTML +=html;
    });
   div.innerHTML += `<p class="mt-3 text-center"><small>Mostrando ${Vehicles.length} vehiculos</small></p>`;
   const btnsDetail = document.querySelectorAll(".btnDetail");
   btnsDetail.forEach(btn => {
       btn.addEventListener('click', getVehicle);
   });

}

 async function getVehicle(e) {
    try {
        e.preventDefault(); // Evita la acción predeterminada del enlace

        let id = e.currentTarget.dataset.id; 
       
        if (!id) {
            console.error("¡No se encontró el ID del vehiculo!");
            return;
        }
        const response = await fetch(BASE_URL + "vehicle/" + id, {
            method: "GET"});
        if (!response.ok) {
            throw new Error("Error al obtener los detalles de la película.");
        }
        
       vehicle = await response.json();
        showVehicle(); // Llama a la función para mostrar los detalles de la película
        
    } catch (error) {
        console.log(error);
    }
 }
 function showVehicle() {
    
        let div = document.getElementById("contenedorMostrar");
        div.innerHTML = "";
        if (!vehicle) {
            div.innerHTML = "<p>Detalles del vehículo no encontrados.</p>";
            return;
        }
        // Suponiendo que 'vehicle.images' contiene las imágenes del vehículo
        let carouselItems = vehicle.images.map((image, index) => {
            return `
                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                    <img src="uploads/${image}" class="d-block w-100" alt="Imagen de ${vehicle.name}">
                </div>
            `;
        }).join('');
        
        let html = `
            <div class="container mt-4 informacion">
                <h1 class="mb-4">${vehicle.car_brand}</h1>
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        ${carouselItems}
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="card">
                    <div class="card-body">
                        <p class="card-text"><strong>version: ${vehicle.version}</strong></p>
                        <p class="card-text"><strong>version: ${vehicle.year}</strong></p>
                        <p class="card-text"><strong>version: ${vehicle.mileage}</strong></p>
                        <p class="card-text"><strong>Precio: ${vehicle.description}</strong></p>
                        <p class="card-text"><strong>Descripción: ${vehicle.price}</strong></p>
                    </div>
                </div>
            </div>
        `;
        div.innerHTML += html;
    }
    

 
getAllVehicles();
console.log(BASE_URL);
console.log(vehicle);
console.log(Vehicles);
