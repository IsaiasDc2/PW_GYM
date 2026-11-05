document.addEventListener("DOMContentLoaded", function () {
  const seccion = document.querySelector("[data-api-clases]");
  if (!seccion) return;

  const inputBusqueda = document.getElementById("api-busqueda");
  const selectCategoria = document.getElementById("api-categoria");
  const estado = document.getElementById("api-estado");
  const resultados = document.getElementById("api-resultados");
  const endpoint = seccion.getAttribute("data-endpoint") || "api/clases.php";

  if (!inputBusqueda || !selectCategoria || !estado || !resultados) return;

  let temporizador = null;
  let controlador = null;

  function crearMensaje(texto) {
    const columna = document.createElement("div");
    columna.className = "col-12";
    const parrafo = document.createElement("p");
    parrafo.className = "muted mb-0";
    parrafo.textContent = texto;
    columna.appendChild(parrafo);
    return columna;
  }

  function crearTarjeta(clase) {
    const columna = document.createElement("div");
    columna.className = "col-md-6";

    const tarjeta = document.createElement("article");
    tarjeta.className = "card h-100";

    const titulo = document.createElement("h3");
    titulo.textContent = clase.nombre;

    const categoria = document.createElement("p");
    const categoriaFuerte = document.createElement("strong");
    categoriaFuerte.textContent = "Categoría: ";
    categoria.appendChild(categoriaFuerte);
    categoria.appendChild(document.createTextNode(clase.categoria));

    const horario = document.createElement("p");
    const horarioFuerte = document.createElement("strong");
    horarioFuerte.textContent = "Horario: ";
    horario.appendChild(horarioFuerte);
    horario.appendChild(document.createTextNode(clase.dia_semana + " " + clase.hora));

    const instructor = document.createElement("p");
    instructor.className = "muted";
    instructor.textContent = "Instructor: " + clase.instructor;

    const sede = document.createElement("p");
    sede.className = "muted small";
    sede.textContent = "Sede: " + clase.sede + " · Cupo: " + clase.cupo;

    tarjeta.append(titulo, categoria, horario, instructor, sede);
    columna.appendChild(tarjeta);
    return columna;
  }

  function renderizar(clases) {
    resultados.innerHTML = "";
    if (clases.length === 0) {
      resultados.appendChild(crearMensaje("No se encontraron clases con esos filtros."));
      return;
    }
    const fragmento = document.createDocumentFragment();
    clases.forEach(function (clase) {
      fragmento.appendChild(crearTarjeta(clase));
    });
    resultados.appendChild(fragmento);
  }

  async function buscarClases() {
    if (controlador) controlador.abort();
    const controladorActual = new AbortController();
    controlador = controladorActual;

    const url = new URL(endpoint, window.location.href);
    const busqueda = inputBusqueda.value.trim();
    const categoria = selectCategoria.value;
    if (busqueda) url.searchParams.set("q", busqueda);
    if (categoria) url.searchParams.set("categoria", categoria);

    estado.textContent = "Buscando clases...";
    resultados.setAttribute("aria-busy", "true");

    try {
      const respuesta = await fetch(url, {
        headers: { Accept: "application/json" },
        signal: controladorActual.signal,
      });

      let cuerpo = null;
      try {
        cuerpo = await respuesta.json();
      } catch (error) {
        cuerpo = null;
      }

      if (!respuesta.ok) {
        throw new Error((cuerpo && cuerpo.message) || "Error HTTP " + respuesta.status);
      }
      if (!cuerpo || cuerpo.status !== "success" || !Array.isArray(cuerpo.data)) {
        throw new Error("La respuesta del servidor no tiene el formato esperado.");
      }

      renderizar(cuerpo.data);
      const total = cuerpo.data.length;
      estado.textContent =
        total === 0
          ? "Sin resultados."
          : "Mostrando " + total + (total === 1 ? " clase." : " clases.");
    } catch (error) {
      if (error.name === "AbortError") return;
      console.error("Error al consultar la API de clases:", error);
      resultados.innerHTML = "";
      resultados.appendChild(
        crearMensaje("No se pudieron cargar las clases. Revisá la conexión e intentá nuevamente.")
      );
      estado.textContent = "Error de conexión con la API.";
    } finally {
      if (!controladorActual.signal.aborted) {
        resultados.setAttribute("aria-busy", "false");
      }
    }
  }

  function programarBusqueda() {
    clearTimeout(temporizador);
    temporizador = setTimeout(buscarClases, 300);
  }

  inputBusqueda.addEventListener("input", programarBusqueda);
  selectCategoria.addEventListener("change", buscarClases);

  buscarClases();
});
