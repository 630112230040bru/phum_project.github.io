
    /////ดูว่าเกรดดีหรือไม่///

    let grad = document.querySelectorAll("tr td#grad");
    let criterion = document.querySelectorAll("tr td#criterion");

    let risky = 0;
    let little = 0;
    let moderate = 0;
    let good = 0;
    let very_good = 0;

    for(let i=0 ; i < grad.length ; i++){

        if (grad[i].innerHTML < 2.00) {
            criterion[i].innerHTML = "เสี่ยง"
            criterion[i].style.color = "#ff0000"
            risky++;

        } else if (grad[i].innerHTML < 2.50) {
            criterion[i].innerHTML = "น้อย"
            criterion[i].style.color = "#8B0000"
            little++;

        } else if (grad[i].innerHTML < 3) {
            criterion[i].innerHTML = "ปานกลาง"
            criterion[i].style.color = "#FF7F50"
            moderate++;
        } else if (grad[i].innerHTML < 3.50) {
            criterion[i].innerHTML = "ดี"
            criterion[i].style.color = "#006400"
            good++;
        } else {
            criterion[i].innerHTML = "ดีมาก"
            criterion[i].style.color = "#006400"
            very_good++;
        }

    }


    let show_num_grad = document.querySelectorAll("h4#show_num_grad");
    
    show_num_grad[0].innerHTML = "อยู่ในเกณฑ์เสี่ยง "+risky+" คน";
    show_num_grad[1].innerHTML = "อยู่ในเกณฑ์น้อย "+little+" คน";
    show_num_grad[2].innerHTML = "อยู่ในเกณฑ์ปานกลาง "+moderate+" คน";
    show_num_grad[3].innerHTML = "อยู่ในเกณฑ์ ดี-ดีมาก "+(good+very_good)+" คน";

    //////////////////////////////ส่วนของกราฟวงกรม//////////////////////////

    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["เสี่ยง", "น้อย", "ปานกลาง","ดี","ดีมาก"],
        datasets: [{
        data: [risky,little,moderate,good,very_good],
        backgroundColor: ['#000000', '#dc3545', '#ffc107','#7FFF00','#006400'],
        }],
    },
    });

    //////////////////////////////ส่วนของกราฟบาฉาด//////////////////////////

    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';

    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["เสี่ยง", "น้อย", "ปานกลาง","ดี","ดีมาก"],
        datasets: [{
        label: "Sessions",
        lineTension: 0.3,
        backgroundColor: "rgba(2,117,216,0.2)",
        borderColor: "rgba(2,117,216,1)",
        pointRadius: 5,
        pointBackgroundColor: "rgba(2,117,216,1)",
        pointBorderColor: "rgba(255,255,255,0.8)",
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(2,117,216,1)",
        pointHitRadius: 50,
        pointBorderWidth: 2,
        data: [risky,little,moderate,good,very_good],
        }],
    },
    options: {
        scales: {
        xAxes: [{
            time: {
            unit: 'date'
            },
            gridLines: {
            display: false
            },
            ticks: {
            maxTicksLimit: 8
            }
        }],
        yAxes: [{
            ticks: {
            min: 0,
            max: grad.length,
            maxTicksLimit: 8
            },
            gridLines: {
            color: "rgba(0, 0, 0, .125)",
            }
        }],
        },
        legend: {
        display: false
        }
    }
    });


    

    