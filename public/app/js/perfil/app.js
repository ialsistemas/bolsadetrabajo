document.addEventListener('DOMContentLoaded', function() {
    const alumnoId = document.getElementById('alumnoId').value;
    console.log('Alumno ID:', alumnoId);
    fetchProgresoCV(alumnoId);
});
async function fetchProgresoCV(alumnoId) {
    try {
        const response = await fetch(routeProgreso, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': tokenWeb
            },
            body: JSON.stringify({
                alumnoId: alumnoId
            })
        });
        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`Error: ${response.status} - ${errorText}`);
        }
        const data = await response.json();
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        progressBar.value = data.progreso;
        progressText.textContent = `${data.progreso}%`;
    } catch (error) {
        console.error('Error:', error);
    }
}
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("dni").focus();
});