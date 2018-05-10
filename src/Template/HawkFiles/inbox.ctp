

<?php

echo $this->Html->css([
    'dataTables/datatables.min',
    'protocol'
]);
echo $this->Flash->render();
?>

    <section class="section">
        <h3 class="title is-4 card-footer-item">Πρωτόκολλο εισερχομένων 180 ΜΚ/Β HAWK</h3>
        <form class="form-horizontal box"">

            <div class="columns">
                <div class="column">
                    <input id="s_number" class="custom-input" type="text" placeholder="Αναζήτηση Αριθμού Ταυτότητας">
                </div>
                <div class="column">
                    <input id="s_topic" class="custom-input" type="text" placeholder="Αναζήτηση Θέματος">
                </div>
                <div class="column">
                    <input id="s_protocol" class="custom-input" type="text" placeholder="Αναζήτηση Φ/SIC">
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="select is-dark is-fullwidth">
                        <select id="s_office"
                                data-live-search="true"
                                title="Υπόψιν Γραφείου">
                            <option value="">Όλα τα γραφεία</option>
                        </select>
                    </div>
                    <div class="select is-dark is-fullwidth">
                        <select id="s_type"
                                data-live-search="true"
                                title="Επιλέξτε τύπο εγγράφου">
                            <option value="">Όλοι οι τυποι</option>
                        </select>
                    </div>
                    <div class="select is-dark is-fullwidth">
                        <select id="s_sender" class="selectpicker"
                                data-live-search="true"
                                title="Επιλέξτε Αποστολέα">
                            <option value="">Όλοι οι αποστολείς</option>
                        </select>
                    </div>
                </div>
                <div class="column is-block">
                    <label for="s_created_after" class="label">Από:</label>
                    <input id="s_created_after" class="input" type="date">
                </div>
                <div class="column">
                    <label for="s_created_before" class="label">Εώς:</label>
                    <input id="s_created_before" class="input" type="date">
                </div>
            </div>
            <div class="clearfix"></div>
        </form>
    </section>

    <div class="columns is-block-widescreen">
        <table id="protocolTable" class="table table-hover table-dark text-center"></table>
    </div>

<?php


echo $this->Html->script([
    'dataTables/datatables.min',
    'protocol',
    'dateFunctions',
]);

?>
