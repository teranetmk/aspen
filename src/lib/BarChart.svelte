<script>
import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { afterUpdate } from 'svelte';

export let title, loading, dateRange;
export let values, labels, bgs;
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
          borderRadius: 10,
          backgroundColor: bgs
        },
      ],
    },
    plugins: [ChartDataLabels],
    options: {
      aspectRatio: 4,
      maintainAspectRatio: false,
      plugins: {
        datalabels: {
          anchor: 'end',
          align: 'start',
          offset: -18,
        },
        tooltip: {
          enabled: false,
        },
        legend: {
          display: false,
        },
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

