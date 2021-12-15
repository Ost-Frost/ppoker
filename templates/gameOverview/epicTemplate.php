
<div>
    <div id="<?= $templateProperties["epicID"] ?>" class="p-4 pe-auto" onclick="epic(event)">
        <h2>
            <span><?= $templateProperties["epicName"] ?> <?= $templateProperties["epicHost"] ?> </span>
            <span id="storyPoints_<?= $templateProperties["epicID"] ?>" class="text-secondary pe-none" style="text-decoration: none;">-</span>
            <span class="text-secondary pe-none" style="text-decoration: none;"> Story Points</span>
            <img id="chevronRight_<?= $templateProperties["epicID"] ?>" src="IMG/chevron-double-right.svg" alt="chevron right" width="24" height="24" class="mb-1">
            <img id="chevronDown_<?= $templateProperties["epicID"] ?>" src="IMG/chevron-double-down.svg" alt="chevron down" width="24" height="24" class="d-none mb-1">
        </h2>
        <div id="epicDescription_<?= $templateProperties["epicID"] ?>" class="d-none pe-none">
            <div class="pe-none">Beschreibung:</div>
            <div class="pe-none"><?= $templateProperties["epicDescription"] ?></div>
        </div>
    </div>
    <hr>
    <div id="extendedArea_<?= $templateProperties["epicID"] ?>" class="d-none list-group-flush border-bottom scrollarea">
        <?= $templateProperties["epicSpiele"] ?>
    </div>
</div>