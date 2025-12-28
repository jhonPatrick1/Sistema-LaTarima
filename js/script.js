document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registroForm");
  const mensajeDiv = document.getElementById("mensaje");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    const response = await fetch("https://localhost:5001/api/registro/RegistrarUsuario", {
      method: "POST",
      body: formData
    });

    if (response.ok) {
      mensajeDiv.innerHTML = `<p class="text-success fw-bold">✅ Registrado correctamente</p>`;
      form.reset();
    } else {
      mensajeDiv.innerHTML = `<p class="text-danger fw-bold">❌ Error al registrar</p>`;
    }
  });
});
