document.addEventListener("DOMContentLoaded", function () {
    const showLink = document.getElementById("show");
    const showUpdateLink = document.getElementById("showUpdate");
    const tableRows = document.querySelectorAll(
        ".recent-orders table tbody tr"
    );
    const tableUpdateRows = document.querySelectorAll(
        ".recent-updates table tbody tr"
    );

    showLink.addEventListener("click", function (e) {
        e.preventDefault();

        if (showLink.innerText === "Show All") {
            tableRows.forEach(function (row) {
                row.classList.remove("hidden");
            });
            showLink.innerText = "Close";
        } else {
            for (let i = 3; i < tableRows.length; i++) {
                tableRows[i].classList.add("hidden");
            }
            showLink.innerText = "Show All";
        }
    });

    showUpdateLink.addEventListener("click", function (e) {
        e.preventDefault();

        if (showUpdateLink.innerText === "Show All") {
            tableUpdateRows.forEach(function (row) {
                row.classList.remove("hidden");
            })
            showUpdateLink.innerText = "Close";
        } else {
            for (let i = 3; i < tableUpdateRows.length; i++) {
                tableUpdateRows[i].classList.add("hidden");
            }
            showUpdateLink.innerText = "Show All";
        }
    });

    // Get the date input element
    const dateInput = document.querySelector('input[type="date"]');
    const monthInput = document.getElementById('month');
    const yearInput = document.getElementById('year');

    // Add an event listener for the date change event
    dateInput.addEventListener("change", function () {
        document.getElementById("dateForm").submit(); // Submit the form
    });
    monthInput.addEventListener("change", function () {
        document.getElementById("monthForm").submit(); // Submit the form
    });

    yearInput.addEventListener("change", function () {
        document.getElementById("yearForm").submit(); // Submit the form
    });
});



// Area chart 
const ctx2 = document.getElementById('myBarChart');
const data = Object.values(tradingData);
const months = Object.keys(tradingData);

console.log(data);

new Chart(ctx2, {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Income',
            lineTension: 0.3,
            data: data,
            pointRadius: 5,
            pointHitRadius: 50,
            pointBorderWidth: 2,
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function (value) {
                        return 'RM' + value;
                    },
                    min: 0,
                    max: 10,
                    maxTicksLimit: 5
                }
            }
        }
    }
});
// Area chart

const topProductData = Object.values(topproduct);
const topProductLabels = Object.keys(topproduct);


// Bar Chart 
var ctx = document.getElementById("myAreaChart");

var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: topProductLabels,
        datasets: [{
            label: "Top Sales Products",
            lineTension: 0.3,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
              ],
              borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
            ],
            borderWidth: 1,
            
            data: topProductData,
        }],
    },
    options: {
        scales: {
            x: {
                time: {
                    unit: 'date'
                },
                gridLines: {
                    display: false
                },
                ticks: {
                    maxTicksLimit: 7
                }
            },
            y: {
                ticks: {
                    min: 0,
                    max: 10,
                    maxTicksLimit: 5
                },
                gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                }
            },
        },
        legend: {
            display: false
        }
    }
});

// Bar Chart 



