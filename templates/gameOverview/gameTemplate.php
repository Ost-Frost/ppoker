<a id="<?= $templateProperties["gameID"] ?>" class="list-group-item list-group-item-action p-4 ps-5 pe-auto" onclick="expand(event)">
    <div class="col-10 mb-1 small pe-none d-flex align-items-center">
        <strong><span><?= $templateProperties["gameTask"] ?> <?= $templateProperties["gameHost"] ?></span></strong>&nbsp;
        <span id="storyPoints_<?= $templateProperties["gameID"] ?>" class="text-secondary pe-none" style="text-decoration: none;">-</span>&nbsp;
        <span class="text-secondary pe-none" style="text-decoration: none;"> Story Points</span>&nbsp;&nbsp;
        <img id="chevronRight_<?= $templateProperties["gameID"] ?>" src="IMG/chevron-right.svg" alt="chevron down" width="16" height="16">
        <img id="chevronDown_<?= $templateProperties["gameID"] ?>" src="IMG/chevron-down.svg" alt="chevron down" width="16" height="16" class="d-none">
    </div>
    <br>
    <div id="extendedArea_<?= $templateProperties["gameID"] ?>" class="pe-none d-none">
        Beschreibung:<br>
        <div class="col-10 mb-1 small pe-none" style="margin-bottom: 1%;">
            <?= $templateProperties["gameDescription"] ?>
        </div>
        Mitspieler:<br>
        <div class="col-10 mb-1 small pe-none" style="margin-bottom: 1%;">
            <ul id="userList_<?= $templateProperties["gameID"] ?>"></ul>
        </div>
        <div class="pe-auto">
            <button id="cardBtn_1_<?= $templateProperties["gameID"] ?>" class="btn btn-outline-primary pe-auto" style="margin: 10px;" onclick="playCard(event);">
                <div class="btn-card-od">1</div>
            </button>
            <button id="cardBtn_2_<?= $templateProperties["gameID"] ?>" class="btn btn-outline-primary pe-auto" style="margin: 10px;" onclick="playCard(event);">
                <div class="btn-card-od">2</div>
            </button>
            <button id="cardBtn_3_<?= $templateProperties["gameID"] ?>" class="btn btn-outline-primary pe-auto" style="margin: 10px;" onclick="playCard(event);">
                <div class="btn-card-od">3</div>
            </button>
            <button id="cardBtn_5_<?= $templateProperties["gameID"] ?>" class="btn btn-outline-primary pe-auto" style="margin: 10px;" onclick="playCard(event);">
                <div class="btn-card-od">5</div>
            </button>
            <button id="cardBtn_8_<?= $templateProperties["gameID"] ?>" class="btn btn-outline-primary pe-auto" style="margin: 10px;" onclick="playCard(event);">
                <div class="btn-card-od">8</div>
            </button>
            <button id="cardBtn_13_<?= $templateProperties["gameID"] ?>" class="btn btn-outline-primary pe-auto" style="margin: 10px;" onclick="playCard(event);">
                <div class="btn-card-td">13</div>
            </button>
            <button id="cardBtn_21_<?= $templateProperties["gameID"] ?>" class="btn btn-outline-primary pe-auto" style="margin: 10px;" onclick="playCard(event);">
                <div class="btn-card-td">21</div>
            </button>
            <button id="cardBtn_34_<?= $templateProperties["gameID"] ?>" class="btn btn-outline-primary pe-auto" style="margin: 10px;" onclick="playCard(event);">
                <div class="btn-card-td">34</div>
            </button>
            <button id="cardBtn_55_<?= $templateProperties["gameID"] ?>" class="btn btn-outline-primary pe-auto" style="margin: 10px;" onclick="playCard(event);">
                <div class="btn-card-td">55</div>
            </button>
            <button id="cardBtn_89_<?= $templateProperties["gameID"] ?>" class="btn btn-outline-primary pe-auto" style="margin: 10px;" onclick="playCard(event);">
                <div class="btn-card-td">89</div>
            </button>
            <button id="cardBtn_144_<?= $templateProperties["gameID"] ?>" class="btn btn-outline-primary pe-auto" style="margin: 10px;" onclick="playCard(event);">
                <div class="btn-card">144</div>
            </button>
        </div>
        <?php
            if ($templateProperties["isHost"]) {
                echo '<button class="btn btn-lg btn-danger pe-auto mb-2" type="button" onClick="deleteGame(event);" style="margin-left: 10px;">Löschen</button>';
            } else {
                echo '<button class="btn btn-lg btn-danger pe-auto mb-2" type="button" onClick="leave(event);" style="margin-left: 10px;">Verlassen</button>';
            }
        ?>
    </div>
</a>