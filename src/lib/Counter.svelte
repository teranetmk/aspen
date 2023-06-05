<script>
import Chart from 'chart.js/auto';
import { CountUp } from 'countup.js';
import { onMount } from 'svelte';

export let title;
export let score;
let canvas, chart;
let countUp, scoreEl;

onMount(() => {
  chart = new Chart( canvas, {
    type: 'doughnut',
    data: {
      datasets: [
        {
          label: title,
          data: [score, 100-score],
          backgroundColor: ['rgba(255,255,255,1)', 'rgba(255,255,255,0.4)'],
        },
      ],
    },
    options: {
      circumference: 180,
      rotation: -90,
      aspectRatio: 2,
      cutout: '50%',
    }
  });

  countUp = new CountUp( scoreEl, score, {
    suffix: '%',
    duration: 1.5,
  });
  countUp.start();

});
</script>

<div class="doughnut-container">
  <div>{title}</div>
  <div class=chart-container>
    <canvas bind:this={canvas}></canvas>
    <span class="min">0</span>
    <span class="max">100</span>
    <span class="score" bind:this={scoreEl}></span>
    <!-- <span class="score" bind:this={scoreEl}>{score}%</span> -->
  </div>
</div>

<style>
.doughnut-container {
  padding: 20px 20px 40px;
  color: white;
}
.chart-container {
  position: relative;
}
.chart-container > span {
  position: absolute;
  line-height: 1;
  top: 100%;
}
.min {
  left: 12%;
  transform: translateY(10px);
}
.max {
  right: 12%;
  transform: translateY(10px);
}
.score {
  left: 50%;
  transform: translate(-50%, -100%);
  font-size: 32px;
  /* font-weight: bold; */
  line-height: 1;
}
</style>
