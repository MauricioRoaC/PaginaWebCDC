
document.getElementById("contactForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    // Elementos de feedback (asegúrate de que haya un solo #contactSuccess y un solo #contactError)
    const successEl = document.getElementById("contactSuccess");
    const errorEl = document.getElementById("contactError");
    successEl.style.display = "none";
    errorEl.style.display = "none";

    const formData = {
        name: document.getElementById("name").value.trim(),
        email: document.getElementById("email").value.trim(),
        message: document.getElementById("message").value.trim()
    };

    const normalize = value => value.toLowerCase().normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .replace(/[01345@]/g, char => ({"0":"o","1":"i","3":"e","4":"a","5":"s","@":"a"})[char]);
    const offensive = /(?:^|[^\p{L}\p{N}])(?:mierda|puta|putas|puto|putos|carajo|cojudo|cojuda|cojudos|cojudas|pendejo|pendeja|pendejos|pendejas|imbecil|imbeciles|idiota|idiotas|cabron|cabrones|gilipollas|pelotudo|pelotuda|huevon|huevona|huevones|webon|webona|jodete|maricon|maricones|cabrón|conchudo|conchuda)(?=$|[^\p{L}\p{N}])/u;
    if ([formData.name, formData.message].some(value => offensive.test(normalize(value)))) {
        errorEl.textContent = "Tu mensaje contiene lenguaje inapropiado. Por favor, reformúlalo antes de enviarlo.";
        errorEl.style.display = "block";
        return;
    }

    // <-- Aquí la ruta correcta según tu routes/api.php -->
    const apiUrl = "http://127.0.0.1:8000/api/contact/messages";

    try {
        const response = await fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(formData)
        });

        let result = null;
        try { result = await response.json(); } catch (err) {}

        if (response.ok) {
            successEl.style.display = "block";
            errorEl.style.display = "none";
            document.getElementById("contactForm").reset();
        } else {
            errorEl.textContent = (result && (result.errors?.message?.[0] || result.errors?.name?.[0] || result.message || JSON.stringify(result))) || "Ocurrió un error al enviar el mensaje.";
            errorEl.style.display = "block";
            successEl.style.display = "none";
        }
    } catch (err) {
        errorEl.textContent = "Error de red: verifica que el backend esté corriendo y que la URL sea correcta.";
        errorEl.style.display = "block";
        successEl.style.display = "none";
        console.error("Fetch error:", err);
    }
});

