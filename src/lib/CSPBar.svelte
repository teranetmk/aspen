<script>
import Chart from 'chart.js/auto';
import { afterUpdate } from 'svelte';

export let csp = 0;
let canvas, chart;

function createChart() {

  if (chart) {
    chart.options.animate = false;
    chart.destroy();
  }
  chart = new Chart( canvas, {
    type: 'bar',
    data: {
      labels: [''],
      datasets: [
        {
          data: [csp],
          borderRadius: 4,
          backgroundColor: '#1073CF',
        },
        {
          data: [360],
          borderRadius: 4,
          backgroundColor: '#EEEEEE',
        },
      ],
    },
    options: {
      aspectRatio: 8,
      maintainAspectRatio: false,
      indexAxis: 'y',
      elements: {
        bar: {
        }
      },
      plugins: {
        tooltip: {
          enabled: true,
        },
        legend: {
          display: false,
        },
      },
      scales: {
        x: {
          display: false,
          grid: {
            display: false,
          },
          min: 0,
          max: 360,
          ticks: {
            callback: function(val, index) {
              return val;
            },
          },
        },
        y: {
          stacked: true,
          display: false,
          grid: {
            display: false,
          },
        }
      },
    },
  });
}

afterUpdate(createChart);
</script>

<div class="statbox">
  <div class=chart-container>
    <canvas bind:this={canvas}></canvas>
  </div>
  <div class="labels">
    <div class="silver"><span class="tick"></span><b>Silver</b><br>36 pts</div>
    <div class="gold"><span class="tick"></span><b>Gold</b><br>120 pts</div>
    <div class="platinum"><span class="tick"></span><b>Platinum</b><br>CSP Av: 360 pts</div>
  </div>
</div>

<style>
.chart-container {
  position: relative;
}
.labels {
  position: relative;
  font-family: "Montserrat", sans-serif;
  font-size: 12px;
  line-height: 1;
  text-align: right;
  display: flex;
  justify-content: space-between;
  margin-top: -6px;
}
.labels > * {
  background: transparent;
  flex: 1 0 auto;
}
.labels .tick {
  display: block;
  height: 20px;
  border-right: 1px solid black;
  margin-bottom: 2px;
}
.silver {
  left: 0;
}
.silver {
  transform: translateX(-44px);
}
.silver .tick {
  transform: translateX(-6px);
}
.gold {
  transform: translateX(-54px);
}
.gold .tick {
  transform: translateX(-10px);
}
.platinum {
  transform: translateX(px);
}
.platinum .tick {
  transform: translateX(-1px);
}
</style>

