
<div>
    <h2 class="p-4 pe-auto" onclick="epic(event)">
        <span><?= $templateProperties["epicName"] ?></span>
        <img src="IMG/chevron-double-right.svg" alt="chevron down" width="24" height="24" class="mb-1">
        <img src="IMG/chevron-double-down.svg" alt="chevron down" width="24" height="24" class="d-none mb-1">
    </h2>
    <hr>
    <div class="d-none list-group-flush border-bottom scrollarea">
        <?= $templateProperties["epicSpiele"] ?>
    </div>
</div>