
const contactForm = document.getElementById("contactForm");
const contactMessage = document.getElementById("message");
const contactCount = document.getElementById("contactCount");
const contactSubmit = contactForm.querySelector('button[type="submit"]');
const updateContactCount = () => {
    if (contactCount) contactCount.textContent = contactMessage.value.length + " / 5000 caracteres";
};
contactMessage.addEventListener("input", updateContactCount);
updateContactCount();
let contactSending = false;

contactForm.addEventListener("submit", async function(e) {
    e.preventDefault();
    if (contactSending) return;

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

    if (!formData.name || !formData.message || !formData.email) {
        errorEl.textContent = "Completa todos los campos obligatorios.";
        errorEl.style.display = "block";
        return;
    }

    const normalize = value => value.toLowerCase().normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .replace(/[01345@]/g, char => ({"0":"o","1":"i","3":"e","4":"a","5":"s","@":"a"})[char]);
    const offensive = /(?:^|[^\p{L}\p{N}])(?:estupid[oa]s?|estupidez|perr[oa]s?|hij[oa]s?[\s\p{P}]+de[\s\p{P}]+(?:put[aos]*|perr[aos]*)|mal[\s\p{P}\p{S}]*parid[oa]s?|desgraciad[oa]s?|maldit[oa]s?|bastard[oa]s?|cretin[oa]s?|tarad[oa]s?|retrasad[oa]s?|subnormal(?:es)?|mongolic[oa]s?|imbecil(?:es)?|inutil(?:es)?|babos[oa]s?|bolud[oa]s?|gil(?:es)?|gilipollas|soplapollas|culer[oa]s?|cag[oa]n(?:es|as)?|cagada|cagadas|mierdas|mierder[oa]s?|mama[\s\p{P}\p{S}]*huev[oa]s?|chupapollas|chupa[\s\p{P}\p{S}]*medias|chupapijas|chupaverga|vergas?|chingad[oa]s?|chingar|joder|jodid[oa]s?|jodanse|jodete|putamadre|putamadres|hdp|hpd|ctm|ptm|pendej[oa]s?|cojud[oa]s?|cojudeces|cojudez|huevon(?:es|a|as)?|wevon(?:es|a|as)?|webon(?:es|a|as)?|huevadas?|conchud[oa]s?|pelotud[oa]s?|payas[oa]s?|imbecilidades|sin[\s\p{P}\p{S}]*verguenzas?|miserables?|asqueros[oa]s?|basuras?|idioteces|idiotez|idiotas?|putit[oa]s?|putazos?|putones?|put[oa]s?|put|pendej|estupid|cabron(?:es|a|as)?|maricon(?:es|a|as)?|maric[oa]s?|maric[a]s?|cornud[oa]s?|cabr[o]n|mal[\s\p{P}\p{S}]*nacid[oa]s?|desubicad[oa]s?|animal(?:es)?|bestias?|burros?|brut[oa]s?|tont[oa]s?|sons[oa]s?|zon[z]?[oa]s?|papanatas|pateticos?|pateticas?|infeliz(?:es)?|imbec|carajos?|caraj[o]s?|pajer[oa]s?|chot[oa]s?|forr[oa]s?|ortiv[oa]s?|culiad[oa]s?|culia[oa]s?|mal[\s\p{P}\p{S}]*cogid[oa]s?|conchetumare|conchesumare|conchatumadre|conchadesumadre|put[oa]s?[\s\p{P}]+de[\s\p{P}]+mierda|mierda|puta|putas|puto|putos|carajo|cojudo|cojuda|cojudos|cojudas|pendejo|pendeja|pendejos|pendejas|imbecil|imbeciles|idiota|idiotas|cabron|cabrones|gilipollas|pelotudo|pelotuda|huevon|huevona|huevones|webon|webona|jodete|maricon|maricones|cabrón|conchudo|conchuda)(?=$|[^\p{L}\p{N}])/u;
    if ([formData.name, formData.message].some(value => offensive.test(normalize(value)))) {
        errorEl.textContent = "Tu mensaje contiene lenguaje inapropiado. Por favor, reformúlalo antes de enviarlo.";
        errorEl.style.display = "block";
        return;
    }

    // <-- Aquí la ruta correcta según tu routes/api.php -->
    const apiUrl = window.APP_CONFIG.backendUrl + "/api/contact/messages";

    contactSending = true;
    contactSubmit.disabled = true;
    contactForm.setAttribute("aria-busy", "true");
    const originalLabel = contactSubmit.textContent;
    contactSubmit.textContent = "Enviando mensaje…";
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
            contactForm.reset();
            updateContactCount();
        } else {
            errorEl.textContent = response.status === 429 ? "Has realizado demasiados intentos. Espera un minuto antes de volver a enviar." : (result && (result.errors?.message?.[0] || result.errors?.name?.[0] || result.errors?.email?.[0] || (response.status === 422 ? result.message : null))) || "Ocurrió un error al enviar el mensaje.";
            errorEl.style.display = "block";
            successEl.style.display = "none";
        }
    } catch (err) {
        errorEl.textContent = "No se pudo confirmar el envío. Comprueba tu conexión antes de volver a intentarlo.";
        errorEl.style.display = "block";
        successEl.style.display = "none";
        console.error("Fetch error:", err);
    } finally {
        contactSending = false;
        contactSubmit.disabled = false;
        contactSubmit.textContent = originalLabel;
        contactForm.removeAttribute("aria-busy");
    }
});

