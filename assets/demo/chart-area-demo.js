// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var grade_1_1 = document.getElementById("grade_1_1").value;
var grade_1_2 = document.getElementById("grade_1_2").value;
var grade_2_1 = document.getElementById("grade_2_1").value;
var grade_2_2 = document.getElementById("grade_2_2").value;
var grade_3_1 = document.getElementById("grade_3_1").value;
var grade_3_2 = document.getElementById("grade_3_2").value;
var grade_4_1 = document.getElementById("grade_4_1").value;
var grade_4_2 = document.getElementById("grade_4_2").value;

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["ปี 1 เทอม 1", "ปี 1 เทอม 2", "ปี 2 เทอม 1", "ปี 2 เทอม 2", "ปี 3 เทอม 1", "ปี 3 เทอม 2", "ปี 4 เทอม 1", "ปี 4 เทอม 2"],
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
      data: [grade_1_1,grade_1_2,grade_2_1,grade_2_2,grade_3_1,grade_3_2,grade_4_1,grade_4_2],
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
          max: 4,
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
