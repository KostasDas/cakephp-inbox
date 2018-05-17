

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

            <div class="clearfix"></div>
        <div class="columns">
            <div class="column">
                <?php if ($isAdmin) :?>
                <div class="select is-dark is-fullwidth">
                    <select id="s_user"
                            data-live-search="true"
                            title="Χειριστής">
                        <option value="">Όλοι οι χρήστες</option>
                    </select>
                </div>
                <?php endif; ?>
                <div class="select is-dark is-fullwidth">
                    <select id="s_type"
                            data-live-search="true"
                            title="Επιλέξτε είδος αλληλογραφίας">
                        <option value="">Όλα τα είδη αλληλογραφίας</option>
                    </select>
                </div>
                <div class="select is-dark is-fullwidth">
                    <select id="s_sender"
                            data-live-search="true"
                            title="Επιλέξτε Αποστολέα">
                        <option value="">Όλοι οι αποστολείς</option>
                    </select>
                </div>
                <div class="select is-dark is-fullwidth">
                    <select id="s_file_type"
                            data-live-search="true"
                            title="Επιλέξτε Τύπο αρχείου">
                        <option value="">Όλοι οι τύποι αρχείων</option>
                        <option value="εισερχομενο">Εισερχόμενο</option>
                        <option value="εξερχομενο">Εξερχόμενο</option>
                    </select>
                </div>
            </div>
            <div class="column is-block">
                <label for="s_created_after" class="label">Από:</label>
                <input id="s_created_after" class="is-dark input" type="date">
            </div>
            <div class="column">
                <label for="s_created_before" class="label">Εώς:</label>
                <input id="s_created_before" class="is-dark input" type="date">
            </div>
        </div>
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
