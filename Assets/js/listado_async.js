
const tblUsuarios_body = document.getElementById("tblUsuario_body");

document.addEventListener("DOMContentLoaded", ()=>{
    cargarUsuarios();
});

async function cargarUsuarios() {
    var data = await fetch(BASE_URL+"/users/cargarUsuariosAsync").then( (response)=>
        response.json()
    );

    var str_html = "";
    data.forEach(elem => {
        str_html += "<tr>" +
            "<td>" + elem.id + "</td>" +
            "<td>" + elem.correo + "</td>" +
            "</tr>";
    });

    tblUsuarios_body.innerHTML = str_html;
}
