<a class="list-group-item list-group-item-action p-4 ps-5 pe-auto" onclick="expand(event)">
    <div class="d-flex w-100 align-items-center justify-content-between pe-none">
        <strong class="mb-1 pe-none">Spiel von <?= $templateProperties["hostName"] ?></strong>
    </div>
    <div class="col-10 mb-1 small pe-none">
        <?= $templateProperties["gameTask"] ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-chevron-compact-right pe-none" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg " width="16" height="16" fill="currentColor"
            class="bi bi-chevron-compact-down d-none" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z" />
        </svg>
    </div>
    <br>
    <div class="pe-none d-none">Beschreibung:<br>
        <div class="col-10 mb-1 small pe-none" style="margin-bottom: 1%;">
            <?= $templateProperties["gameDescription"] ?>
        </div>
        <button class="btn btn-lg btn-success pe-auto" href="#">Beitreten</button>
        <button class="btn btn-lg btn-danger pe-auto" href="#"
            style="margin-left: 10px;">Ablehnen</button>
    </div>
</a>