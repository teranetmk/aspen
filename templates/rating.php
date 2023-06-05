<div class="rating" style="display: flex; justify-content: space-between; align-items: center;">
   <div class="rating-value"><?=  sprintf("%0.1f",$rating); ?></div>
   <?php for ($i = 1; $i <= 5; $i++): ?>
   <?php if ($rating >= $i): ?>
		<svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M7.53803 1.09319C7.77655 0.633547 8.43406 0.633548 8.67257 1.09319L10.4435 4.50594C10.5362 4.68456 10.7076 4.80909 10.9061 4.84205L14.699 5.47169C15.2099 5.55649 15.4131 6.18182 15.0496 6.5507L12.3512 9.28953C12.2099 9.43288 12.1445 9.63437 12.1745 9.83336L12.7477 13.6352C12.8249 14.1473 12.293 14.5338 11.8299 14.3021L8.39121 12.5821C8.21123 12.492 7.99937 12.492 7.81939 12.5821L4.38073 14.3021C3.9176 14.5338 3.38566 14.1473 3.46287 13.6352L4.03614 9.83336C4.06614 9.63437 4.00067 9.43288 3.85944 9.28953L1.16096 6.55069C0.797517 6.18182 1.0007 5.55649 1.51155 5.47169L5.30451 4.84205C5.50303 4.80909 5.67443 4.68456 5.76712 4.50594L7.53803 1.09319Z" fill="#FFA04E"/>
		</svg>
   <?php elseif ($rating < $i && $rating >= ($i - 0.5)): ?>
		
		<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M6.43275 1.09321C6.67126 0.633563 7.32877 0.633562 7.56729 1.09321L9.27445 4.38311C9.36714 4.56173 9.53854 4.68626 9.73706 4.71922L13.3935 5.32619C13.9043 5.41099 14.1075 6.03632 13.7441 6.4052L11.1427 9.04544C11.0015 9.18879 10.936 9.39029 10.966 9.58927L11.5187 13.2543C11.5959 13.7664 11.0639 14.1528 10.6008 13.9212L7.28593 12.263C7.10595 12.173 6.89408 12.173 6.71411 12.263L3.39923 13.9212C2.93609 14.1528 2.40416 13.7664 2.48137 13.2543L3.034 9.58927C3.064 9.39029 2.99853 9.18879 2.8573 9.04544L0.255959 6.4052C-0.107484 6.03632 0.0956967 5.41099 0.60655 5.32619L4.26298 4.71922C4.46149 4.68626 4.6329 4.56173 4.72559 4.38311L6.43275 1.09321Z" fill="#D6DCDC"/>
		<path d="M7.00004 0.748488V12.1955C6.90208 12.1955 6.80409 12.218 6.71411 12.263L3.39923 13.9212C2.93609 14.1528 2.40416 13.7664 2.48137 13.2543L3.034 9.58927C3.064 9.39029 2.99853 9.18879 2.8573 9.04544L0.255959 6.4052C-0.107484 6.03632 0.0956967 5.41099 0.60655 5.32619L4.26298 4.71922C4.46149 4.68626 4.6329 4.56173 4.72559 4.38311L6.43275 1.09321C6.55201 0.86338 6.77604 0.748488 7.00004 0.748488Z" fill="#FFA04E"/>
		</svg>

   <?php else: ?>
		<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M7.50581 1.24037C7.62507 1.01055 7.95382 1.01055 8.07308 1.24037L9.84399 4.65312C9.98302 4.92105 10.2401 5.10785 10.5379 5.15728L14.3309 5.78692C14.5863 5.82932 14.6879 6.14198 14.5062 6.32643L11.8077 9.06526C11.5958 9.28028 11.4976 9.58252 11.5426 9.881L12.1159 13.6829C12.1545 13.9389 11.8885 14.1322 11.657 14.0163L8.21831 12.2963C7.94834 12.1612 7.63054 12.1612 7.36058 12.2963L3.92192 14.0163C3.69035 14.1322 3.42439 13.9389 3.46299 13.6829L4.03626 9.881C4.08126 9.58252 3.98306 9.28028 3.77121 9.06526L1.07273 6.32642C0.891008 6.14199 0.992597 5.82932 1.24803 5.78692L5.04099 5.15728C5.33876 5.10785 5.59587 4.92105 5.7349 4.65312L7.50581 1.24037Z" fill="#D6DCDC" stroke="#E9EBEB" stroke-width="0.639095"/>
		</svg>
   <?php endif ?>
   <?php endfor ?>
  
</div>

<style>
   .rating .rating-value {
	color: #1073CF;
	font-size: 23px;
	font-weight: 600;
	margin: 0 4px 0 0 !important;
	display: inline-block;
	font-family: 'Montserrat' !important;
	line-height: 32px;
   }
   .rating .fa-star,
   .rating .fa-star-half-alt {
   display: inline-block;
   margin: 0 3px;
   }
   .rating svg {
   margin-left: 6px
   }
</style>