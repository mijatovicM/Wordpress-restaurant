<?php
function delete(){?>
    <!-- Javascript function for deleting news -->
                            <script language="javascript">
                                function deleteme(delid)
                                {
                                    if(confirm("Da li sigurno želite da obrišete ovu vest?")){
                                        window.location.href='delete.php?del_id=' +delid+'';
                                        alert('Uspešno ste izbrisali vest');
                                        return true;
                                    }
                                }


                            </script>

<?php } ?>

<?php
function approve(){?>
    <!-- Javascript function for approving news -->
    <script language="javascript">
        function approveme(approveid)
        {
            if(confirm("Da li sigurno želite da odobrite ovu vest?")){
                window.location.href='approve.php?approve_id=' +approveid+'';
                alert('Odobrili ste vest');
                return true;
            }
        }


    </script>

<?php } ?>

<?php
function deletecomment(){?>
    <!-- Javascript function for deleting comments -->
    <script language="javascript">
        function deletecomm(delcommid)
        {
            if(confirm("Da li sigurno želite da obrišete ovaj komentar?")){
                window.location.href='deletecomments.php?delcomm_id=' +delcommid+'';
                alert('Uspešno ste izbrisali komentar');
                return true;
            }
        }


    </script>

<?php } ?>
<?php
function approvecomment(){?>
    <!-- Javascript function for approving comments -->
    <script language="javascript">
        function approvecomm(approvecommid)
        {
            if(confirm("Da li sigurno želite da odobrite ovaj komentar?")){
                window.location.href='approvecomments.php?approvecomm_id=' +approvecommid+'';
                alert('Odobrili ste komentar');
                return true;
            }
        }


    </script>

<?php } ?>

<?php
function deleteuser(){?>
    <!-- Javascript function for deleting users -->
    <script language="javascript">
        function deleteu(deluid)
        {
            if(confirm("Da li sigurno želite da obrišete ovog korisnika?")){
                window.location.href='deleteuser.php?delu_id=' +deluid+'';
                alert('Uspešno ste izbrisali korisnika');
                return true;

            }
        }


    </script>

<?php } ?>

<?php
function deletecomm(){?>
<!-- Javascript function for deleting comments from news page -->
<script language="javascript">
    function deletecommm(delcommmid)
    {
        if(confirm("Da li sigurno želite da obrišete ovaj komentar?")){
            window.location.href='deletecomm.php?delcommm_id=' +delcommmid+'';
            alert('Uspešno ste izbrisali komentar');
            return true;
        }
    }


</script>


<?php }?>


