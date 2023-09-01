const detailDiagnosisModal = document.querySelector('#detailDiagnosisModal');
const titleDetailDiagnosisModal = detailDiagnosisModal.querySelector('.modal-title');
const instanceDetailDiagnosisModal = bootstrap.Modal.getOrCreateInstance(detailDiagnosisModal);
const headerDetailDiagnosis = document.getElementById('headerDetailDiagnosis');
const subheaderDetailDiagnosis = document.getElementById('subheaderDetailDiagnosis');
const tidakditemukan = document.getElementById('tidakditemukan');
const containerImagekepribadianDetailDiagnosisModal = document.getElementById('containerImagekepribadianDetailDiagnosisModal');
const headerkepribadianSolution = document.getElementById('headerkepribadianSolution');
const rowDetailkepribadian = document.getElementById('rowDetailkepribadian');
const detailJawabanDiagnosisTable = document.getElementById('detailJawabanDiagnosisTable');
const tableBody = detailJawabanDiagnosisTable.querySelector('tbody');
const placeholder = document.querySelectorAll('.placeholder');

let idkepribadian = null;
let idDiagnosis = null;
let noHistoriDiagnosis = null;
let diagnosed = false;
let labelChart = null;
let valueChart = null;
let chartDiagnosiskepribadian = null;

function getkepribadianIdFromHistori(data, no) {
    idDiagnosis = data;
    noHistoriDiagnosis = no;
    diagnosed = false;
    instanceDetailDiagnosisModal.show();
}

function getkepribadianFromDiagnose(data, wasDiagnosed) {
    idkepribadian = data.idkepribadian;
    idDiagnosis = data.idDiagnosis;
    diagnosed = wasDiagnosed;
    instanceDetailDiagnosisModal.show();
}

function ajaxRequestDetailDiagnosis() {
    return $.ajax({
        url: '/detail-diagnosis',
        method: 'GET',
        data: {
            id_kepribadian: idkepribadian,
            id_diagnosis: idDiagnosis,
        },
    });
}
function ajaxRequestChartDiagnosiskepribadian() {
    return $.ajax({
        url: '/chart-diagnosis-kepribadian',
        method: 'GET',
        data: {
            id_diagnosis: idDiagnosis,
        },
    });
}

detailDiagnosisModal.addEventListener('show.bs.modal', async () => {
    try {
        const response = await ajaxRequestDetailDiagnosis();
        drawDetailDiagnosis(response, diagnosed);
        drawDetailJawabanDiagnosis(response.answerLog);
    } catch (error) {
        swalError(error.responseJSON);
    }

    try {
        const chartData = await ajaxRequestChartDiagnosiskepribadian();
        drawChart(chartData);
    } catch (error) {
        swalError(error.responseJSON);
    }
});



function drawDetailDiagnosis(response, diagnosed) {
    if (diagnosed === false) {
        titleDetailDiagnosisModal.innerText = 'Detail Diagnosis No. ' + noHistoriDiagnosis;
    }else {
        titleDetailDiagnosisModal.innerText = 'Detail Diagnosis Terbesar';
    }

    if (response.kepribadian == null || response.kepribadianUnidentified === true) {
        headerDetailDiagnosis.innerText = "Prosentase menunjukan kepribadian ada lebih dari 1";
        subheaderDetailDiagnosis.innerHTML = 'Harap melakukan test kembali atau segera menghubungi guru bimbingan konseling';
        rowDetailkepribadian.classList.add('d-none');
        headerDetailDiagnosis.classList.remove('d-none');
        subheaderDetailDiagnosis.classList.remove('d-none'); 
    } else {
        headerDetailDiagnosis.innerText = "kepribadian Ditemukan!";
        subheaderDetailDiagnosis.innerHTML = "kepribadian Anda adalah " + `<u>${response.kepribadian.name}</u>`;
        tidakditemukan.innerHTML = '';
        headerDetailDiagnosis.classList.remove('d-none');
        subheaderDetailDiagnosis.classList.remove('d-none');
        tidakditemukan.classList.remove('d-none');

        const kepribadianName = document.getElementById('kepribadianName');
        const kepribadianReason = document.getElementById('kepribadianReason');
        kepribadianName.innerHTML = response.kepribadian.name;
        kepribadianReason.innerHTML = response.kepribadian.reason;

        let kepribadianSolution = response.kepribadian.solution;
        let regex = /(\d+\.)\s*(.*?)(?=(\d+\.|$))/gs;
        let matches = [...kepribadianSolution.matchAll(regex)];
        let nomorAsOlTag = '<ol>';
        for (let i = 0; i < matches.length; i++) {
            nomorAsOlTag += '<li>' + matches[i][2] + '</li>';
        }
        nomorAsOlTag += '</ol>';
        headerkepribadianSolution.insertAdjacentHTML('afterend', nomorAsOlTag);

        const imagekepribadian = new Image();
        imagekepribadian.src = assetStoragekepribadian + '/' + response.kepribadian.image;
        imagekepribadian.alt = response.kepribadian.name;
        imagekepribadian.id = 'imagekepribadian';
        imagekepribadian.classList.add('img-fluid');
        containerImagekepribadianDetailDiagnosisModal.appendChild(imagekepribadian);

        new bootstrap.Tooltip(imagekepribadian, {
            title: response.kepribadian.name,
        });

        imagekepribadian.addEventListener('click', () => {
            const lebarLayar = window.innerWidth || document.documentElement.clientWidth || document
                .body.clientWidth;

            if (lebarLayar >= 992) {
                const chocolatInstance = Chocolat([{
                    src: assetStoragekepribadian + '/' + response.kepribadian.image,
                    title: response.kepribadian.name,
                }], {});
                chocolatInstance.api.open();
            }
        });
    }

    //remove class placeholder
    placeholder.forEach((item) => {
        item.classList.remove('placeholder');
    });
}

function drawDetailJawabanDiagnosis(data) {
    const response = data;
    response.forEach((item, index) => {
        const tableRow = document.createElement('tr');
        const tableData = document.createElement('td');
        const tableData2 = document.createElement('td');
        const tableData3 = document.createElement('td');
        let number = index + 1;
        tableData.innerHTML = number;
        tableData2.innerHTML = item.name;
        tableData3.innerHTML = item.answer;
        tableRow.appendChild(tableData);
        tableRow.appendChild(tableData2);
        tableRow.appendChild(tableData3);
        tableBody.appendChild(tableRow);
    });
}

detailDiagnosisModal.addEventListener('hide.bs.modal', () => {
    containerImagekepribadianDetailDiagnosisModal.innerHTML = '';
    if (headerkepribadianSolution.nextElementSibling) {
        headerkepribadianSolution.nextElementSibling.remove();
    }
    headerDetailDiagnosis.classList.add('d-none');
    subheaderDetailDiagnosis.classList.add('d-none');

    //remove all child element in table body
    while (tableBody.firstChild) {
        tableBody.removeChild(tableBody.firstChild);
    }
    if (chartDiagnosiskepribadian != null) {
        chartDiagnosiskepribadian.destroy();
    }

    rowDetailkepribadian.classList.remove('d-none');
});

detailDiagnosisModal.addEventListener('hidden.bs.modal', () => {

    if (!document.body.classList.contains('modal-open')) {
        document.body.classList.add('modal-open');
    } else {
        document.body.classList.remove('modal-open');
    }
    //add class placeholder
    placeholder.forEach((item) => {
        item.classList.add('placeholder');
    });
});

function drawChart(data) {
    let bobot = data;
    labelChart = Object.entries(bobot).map(([nama, nilai]) => nama);
    valueChart = Object.entries(bobot).map(([nama, nilai]) => nilai);

    var ctx = document.getElementById("chartDiagnosiskepribadian").getContext('2d');
    chartDiagnosiskepribadian = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelChart,
            datasets: [{
                label: 'Persentase',
                data: valueChart,
                borderWidth: 2,
                backgroundColor: '#6777ef',
                borderColor: '#6777ef',
                borderWidth: 2.5,
                pointBackgroundColor: '#ffffff',
                pointRadius: 4
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        drawBorder: false,
                        color: '#f2f2f2',
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 25,
                        max: 100,
                        callback: function (value) {
                            return value + "%"
                        }
                    },
                }],
                xAxes: [{
                    ticks: {
                        display: true
                    },
                    gridLines: {
                        display: true
                    }
                }]
            },
            responsive: true,
            maintainAspectRatio: false,
        }
    });
}
