!function(){window.location.origin;!async function(){try{const t="/api/tareas?id="+d(),a=await fetch(t),o=await a.json();e=o.tareas,n()}catch(e){console.log(e)}}();let e=[],t=[];document.querySelector("#agregar-tarea").addEventListener("click",(function(){o()}));function a(a){const o=a.target.value;t=""!==o?e.filter(e=>e.estado===o):[],n()}function n(){!function(){const e=document.querySelector("#listado-tareas");for(;e.firstChild;)e.removeChild(e.firstChild)}(),function(){const t=e.filter(e=>"0"===e.estado),a=document.querySelector("#pendientes");0===t.length?a.disabled=!0:a.disabled=!1}(),function(){const t=e.filter(e=>"1"===e.estado),a=document.querySelector("#completadas");0===t.length?a.disabled=!0:a.disabled=!1}();const a=t.length?t:e,r=document.querySelector("#listado-tareas");if(0===a.length){const e=document.createElement("LI");return e.textContent="No Hay Tareas Aún",e.classList.add("no-tareas"),void r.appendChild(e)}const i={0:"Pendiente",1:"Completa"};a.forEach(t=>{const a=document.createElement("LI"),r=document.createElement("P"),s=document.createElement("DIV"),l=document.createElement("BUTTON"),u=document.createElement("BUTTON");a.dataset.tareaId=t.id,a.classList.add("tarea"),r.textContent=t.nombre,r.ondblclick=function(){o(!0,{...t})},s.classList.add("opciones"),l.classList.add("estado-tarea"),l.classList.add(""+i[t.estado].toLowerCase()),l.dataset.estadoTarea=t.estado,l.textContent=i[t.estado],l.ondblclick=function(){!function(e){const t="1"===e.estado?"0":"1";e.estado=t,c(e)}({...t})},u.classList.add("eliminar-tarea"),u.dataset.idTarea=t.id,u.textContent="Eliminar",u.ondblclick=function(){!function(t){Swal.fire({title:"¿ELIMINAR TAREA?",showCancelButton:!0,confirmButtonText:"SI",cancelButtonText:"NO"}).then(a=>{a.isConfirmed&&async function(t){const{id:a,nombre:o,estado:r}=t,c=new FormData;c.append("id",a),c.append("nombre",o),c.append("estado",r),c.append("proyectoId",d());try{const a="https://uptask-veron.herokuapp.com/tarea/eliminar",o=await fetch(a,{method:"POST",body:c}),r=await o.json();r.resultado&&(Swal.fire("ELIMINADO!",r.mensaje,"success"),e=e.filter(e=>e.id!==t.id),n())}catch(e){console.log(e)}}(t)})}({...t})},s.appendChild(l),s.appendChild(u),a.appendChild(r),a.appendChild(s);document.querySelector("#listado-tareas").appendChild(a)})}function o(t=!1,a={}){document.querySelector(".body");const o=document.createElement("DIV");o.classList.add("modal"),o.innerHTML=`\n            \x3c!-- Formulario --\x3e\n            <form class="formulario nueva-tarea">\n                <legend>${t?"Editar Tarea":"Añade una nueva tarea"}</legend>\n                \x3c!-- Tarea --\x3e\n                <div class="campo">\n                    <input\n                        type="text"\n                        name="tarea"\n                        placeholder="${a.nombre?"Editar nombre":"Añadir Tarea al Proyecto Actual"}"\n                        id="tarea"\n                        value="${a.nombre?a.nombre:""}"\n                    />\n                </div>\n                \x3c!-- Opciones --\x3e\n                <div class="opciones">\n                    <input \n                        type="submit" \n                        class="submit-nueva-tarea" \n                        value="${t?"Guardar Cambios":"Añadir tarea"}"\n                    />\n                    <button type="button" class="cerrar-modal">Cerrar</button>\n                </div>\n            </form>\n        `,setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),o.addEventListener("click",(function(i){if(i.preventDefault(),i.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{o.remove()},500)}if(i.target.classList.contains("submit-nueva-tarea")){const o=document.querySelector("#tarea").value.trim();if(""===o)return void r("error","El nombre de la tarea es Obligatorio",document.querySelector(".formulario legend"));t?(a.nombre=o,c(a)):async function(t){const a=new FormData;a.append("nombre",t),a.append("proyectoId",d());try{const o="https://uptask-veron.herokuapp.com/api/tarea",c=await fetch(o,{method:"POST",body:a}),d=await c.json();if(r(d.tipo,d.mensaje,document.querySelector(".formulario legend")),"exito"===d.tipo){const a=document.querySelector(".modal");setTimeout(()=>{a.remove()},3e3);const o={id:String(d.id),nombre:t,estado:"0",proyectoId:d.proyectoId};e=[...e,o],n()}}catch(e){console.log(e)}}(o)}})),document.querySelector(".dashboard").appendChild(o)}function r(e,t,a){const n=document.querySelector(".alerta");n&&n.remove();const o=document.createElement("DIV");o.classList.add("alerta",e),o.textContent=t,a.parentElement.insertBefore(o,a.nextElementSibling),setTimeout(()=>{o.remove()},5e3)}async function c(t){const{id:a,nombre:o,estado:r}=t,c=new FormData;c.append("id",a),c.append("nombre",o),c.append("estado",r),c.append("proyectoId",d());try{const t="https://uptask-veron.herokuapp.com/api/tarea/actualizar",d=await fetch(t,{method:"POST",body:c}),i=await d.json();if("exito"===i.respuesta.tipo){Swal.fire("ACTUALIZADO CORRECTAMENTE!",i.respuesta.mensaje,"success");const t=document.querySelector(".modal");t&&t.remove(),e=e.map(e=>(e.id===a&&(e.estado=r,e.nombre=o),e)),n()}}catch(e){console.log(e)}}function d(){const e=new URLSearchParams(window.location.search);return Object.fromEntries(e.entries()).id}document.querySelectorAll('#filtros input[type="radio"]').forEach(e=>{e.addEventListener("input",a)})}();