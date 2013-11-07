
  <table id="flex1" style="display:none"></table>
  <script src="includes/public/js/flexigrid.js"></script>
  <script type="text/javascript">
    $("#flex1").flexigrid({
      url: 'tecnicos/view2',
      dataType: 'json',
      colModel : [
        {display: 'usuarios', name : 'email', width : 40, sortable : true, align: 'center'},
        {display: 'nombre', name : 'nombre', width : 40, sortable : true, align: 'center'},
        {display: 'apellido', name : 'apellido', width : 40, sortable : true, align: 'center'},
        {display: 'celular', name : 'celular', width : 40, sortable : true, align: 'center'},
        ],
      searchitems : [
        {display: 'ISO', name : 'iso'},
        {display: 'Name', name : 'name', isdefault: true}
        ],
      sortname: "iso",
      sortorder: "asc",
      usepager: true,
      title: 'Countries',
      useRp: true,
      rp: 15,
      showTableToggleBtn: true,
      width: 700,
      height: 200
    });
  </script>
