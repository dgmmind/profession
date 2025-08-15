<?php $s = isset($currentStep) ? (int)$currentStep : 1; ?>
<div class="progress-steps">
  <?php for ($i=1; $i<=5; $i++): ?>
    <?php $isActive = ($s === $i); $isDone = ($s >= $i); ?>
    <div class="step <?= $isDone ? 'is-done' : '' ?> <?= $isActive ? 'is-active' : '' ?>">
      <span><?= $i ?></span>
    </div>
  <?php endfor; ?>
</div>
