var co = {
  // (A) SHOW ALL COMPANIES
  pg : 1, // CURRENT PAGE
  find : "", // CURRENT SEARCH
  list : () => {
    cb.page(1);
    cb.load({
      page : "company/list",
      target : "co-list",
      data : {
        page : co.pg,
        search : co.find
      }
    });
  },

  // (B) GO TO PAGE
  //  pg : int, page number
  goToPage : (pg) => { if (pg!=co.pg) {
    co.pg = pg;
    co.list();
  }},

  // (C) SEARCH COMPANY
  search : () => {
    co.find = document.getElementById("co-search").value;
    co.pg = 1;
    co.list();
    return false;
  },

  // (D) SHOW ADD/EDIT DOCKET
  // id : company ID, for edit only
  addEdit : (id) => {
    cb.load({
      page : "company/form",
      target : "cb-page-2",
      data : { id : id ? id : "" },
      onload : () => {
        cb.page(2);
        tinymce.remove();
        tinymce.init({
          selector : "#company_desc",
          menubar : false,
          plugins: "lists link",
          toolbar: "bold italic underline | forecolor | bullist numlist | alignleft aligncenter alignright alignjustify | link"
        });
      }
    });
  },

  // (E) SAVE COMPANY
  save : () => {
    // (E1) GET DATA
    var data = {
      name : document.getElementById("company_name").value,
      slug : document.getElementById("company_slug").value,
      desc : tinymce.get("company_desc").getContent()
    };
    var id = document.getElementById("company_id").value;
    if (id!="") { data.id = id; }

    // (E2) AJAX
    cb.api({
      mod : "company",
      req : "save",
      data : data,
      passmsg : "Company Saved",
      onpass : co.list
    });
    return false;
  },

  // (F) DELETE COMPANY
  //  id : int, company ID
  del : (id) => {
    cb.modal("Please confirm", "Company and the jobs listings will be deleted!", () => {
      cb.api({
        mod : "company",
        req : "del",
        data : { id: id },
        passmsg : "Company Deleted",
        onpass : co.list
      });
    });
  }
};
window.addEventListener("load", co.list);
