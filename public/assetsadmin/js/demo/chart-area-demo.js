// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily =
    "Nunito, -apple-system, system-ui, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif";
Chart.defaults.global.defaultFontColor = "#858796";

// Fungsi untuk format angka
function number_format(
    number,
    decimals = 0,
    dec_point = ".",
    thousands_sep = ","
) {
    number = (number + "").replace(",", "").replace(" ");
    let n = !isFinite(+number) ? 0 : +number;
    let prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
    let s = "",
        toFixedFix = function (n, prec) {
            let k = Math.pow(10, prec);
            return "" + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, thousands_sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec_point);
}

// Inisialisasi data untuk chart
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: [...monthlyData.labels].reverse(), // Pastikan tidak merubah data asli
        datasets: [
            {
                label: "Keterangan Aktif",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [...monthlyData.keteranganAktif].reverse(),
            },
            {
                label: "Keterangan Lulus",
                lineTension: 0.3,
                backgroundColor: "rgba(28, 200, 138, 0.05)",
                borderColor: "rgba(28, 200, 138, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(28, 200, 138, 1)",
                pointBorderColor: "rgba(28, 200, 138, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(28, 200, 138, 1)",
                pointHoverBorderColor: "rgba(28, 200, 138, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [...monthlyData.keteranganLulus].reverse(),
            },
            {
                label: "Laporan Hasil Studi",
                lineTension: 0.3,
                backgroundColor: "rgba(54, 185, 204, 0.05)",
                borderColor: "rgba(54, 185, 204, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(54, 185, 204, 1)",
                pointBorderColor: "rgba(54, 185, 204, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(54, 185, 204, 1)",
                pointHoverBorderColor: "rgba(54, 185, 204, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [...monthlyData.laporanHasilStudi].reverse(),
            },
            {
                label: "Pengantar Mata Kuliah",
                lineTension: 0.3,
                backgroundColor: "rgba(246, 194, 62, 0.05)",
                borderColor: "rgba(246, 194, 62, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(246, 194, 62, 1)",
                pointBorderColor: "rgba(246, 194, 62, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(246, 194, 62, 1)",
                pointHoverBorderColor: "rgba(246, 194, 62, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [...monthlyData.pengantarMataKuliah].reverse(),
            },
        ],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0,
            },
        },
        scales: {
            xAxes: [
                {
                    time: {
                        unit: "month",
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        maxTicksLimit: 7,
                    },
                },
            ],
            yAxes: [
                {
                    ticks: {
                        maxTicksLimit: 5, // Batasi jumlah angka di sumbu Y
                        padding: 10,
                        beginAtZero: true, // Pastikan sumbu dimulai dari 0
                        stepSize: 1, // Pastikan angka tidak berulang di skala kecil
                        callback: function (value) {
                            return value % 1 === 0 ? value : ""; // Hanya tampilkan angka bulat
                        },
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2],
                    },
                },
            ],
        },
        legend: {
            display: true,
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: "#6e707e",
            titleFontSize: 14,
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: true,
            intersect: false,
            mode: "index",
            caretPadding: 10,
            callbacks: {
                label: function (tooltipItem, chart) {
                    var datasetLabel =
                        chart.datasets[tooltipItem.datasetIndex].label || "";
                    return (
                        datasetLabel + ": " + number_format(tooltipItem.yLabel)
                    );
                },
            },
        },
    },
});
