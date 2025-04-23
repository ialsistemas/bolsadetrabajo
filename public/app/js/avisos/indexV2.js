document.addEventListener('DOMContentLoaded', function() {
    const alumnoId = document.getElementById('alumnoId').value;
    console.log('Alumno ID:', alumnoId);
    fetchProgresoCV(alumnoId);
    var cardsListDiv = document.getElementById('cards-list');
    var blockMessageDiv = document.getElementById('block-message');
    if (aprobado === 3) {
        cardsListDiv.style.pointerEvents = 'none';
        cardsListDiv.style.opacity = '0.5';
        blockMessageDiv.style.display = 'block';
    }
});
async function fetchProgresoCV(alumnoId) {
    try {
        const response = await fetch(routeProgreso, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
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