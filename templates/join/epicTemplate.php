
<div>
    <h2 id="<?= $templateProperties["epicID"] ?>" class="p-4 pe-auto" onclick="epic(event)">
        <span><?= $templateProperties["epicName"] ?></span>
        <img id="chevronRight_<?= $templateProperties["epicID"] ?>" src="IMG/chevron-double-right.svg" alt="chevron right" width="24" height="24" class="mb-1">
        <img id="chevronDown_<?= $templateProperties["epicID"] ?>" src="IMG/chevron-double-down.svg" alt="chevron down" width="24" height="24" class="d-none mb-1">
    </h2>
    <hr>
    <div id="extendedArea_<?= $templateProperties["epicID"] ?>" class="d-none list-group-flush border-bottom scrollarea">
        <?= $templateProperties["epicSpiele"] ?>
    </div>
</div>