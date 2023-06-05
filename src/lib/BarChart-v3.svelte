<script>
import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { afterUpdate } from 'svelte';

export let title, loading, dateRange;
export let values, labels;
export let showXAxis = true;
export let showYAxis = false;
export let showXGrid = false;
export let showYGrid = false;
let canvas, chart;

function createChart() {

  if (loading) return;
  if (chart) {
    chart.options.animate = false;
    chart.destroy();
  }
  chart = new Chart( canvas, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          data: values,
          borderRadius: 6,
          backgroundColor: "#1073CF",
          barThickness: 20,
        },
      ],
    },
    plugins: [ChartDataLabels],
    options: {
      onResize: function(_chart, size) {
          if(size.width < 500) {
            _chart.data.datasets[0].barThickness= 5;
          }
          else if(size.width < 700) {
            _chart.data.datasets[0].barThickness= 10;
          } 
          else if(size.width < 900) {
            _chart.data.datasets[0].barThickness= 15;
          } else {
            _chart.data.datasets[0].barThickness= 20;
          }
          _chart.update();
            
      },
      aspectRatio: 4,
      maintainAspectRatio: false,
      plugins: {
        datalabels: {
          anchor: 'end',
          align: 'start',
          offset: -18,
          display: false
        },
        legend: {
          display: false,
        },
        tooltip: {
          enabled: true,
          callbacks: {
            title: () => '',
          }
        }
      },
      layout: {
        padding: {
          top: 30,
        },
      },
      scales: {
        x: {
          display: showXAxis,
          grid: {
            display: showXGrid,
          },
        },
        y: {
          display: showYAxis,
          grid: {
            display: showYGrid,
          },
        }
      },
    },
  });
}

afterUpdate(createChart);
</script>

<div class="statbox">
  {#if title}
    <h4 class="title">{title}: {dateRange}</h4>
  {/if}
  <div class=chart-container>
    <canvas bind:this={canvas}></canvas>
  </div>
</div>

<style>
.chart-container {
  position: relative;
  min-height: 200px;
}
.title {
  font-weight: bold;
  font-size: 20px;
}
</style>

