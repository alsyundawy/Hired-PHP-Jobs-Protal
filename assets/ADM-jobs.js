var job = {
  // (A) SHOW ALL JOBS
  pg : 1, // CURRENT PAGE
  find : "", // CURRENT SEARCH
  list : () => {
    cb.page(1);
    cb.load({
      page : "jobs/list",
      target : "job-list",
      data : {
        page : job.pg,
        search : job.find
      }
    });
  },

  // (B) GO TO PAGE
  //  pg : int, page number
  goToPage : (pg) => { if (pg!=job.pg) {
    job.pg = pg;
    job.list();
  }},

  // (C) SEARCH JOBS
  search : () => {
    job.find = document.getElementById("job-search").value;
    job.pg = 1;
    job.list();
    return false;
  },

  // (D) SHOW ADD/EDIT DOCKET
  // id : job ID, for edit only
  addEdit : (id) => {
    cb.load({
      page : "jobs/form",
      target : "cb-page-2",
      data : { id : id ? id : "" },
      onload : () => {
        tinymce.remove();
        tinymce.init({
          selector : "#job_desc",
          menubar : false,
          plugins: "lists link",
          toolbar: "bold italic underline | forecolor | bullist numlist | alignleft aligncenter alignright alignjustify | link"
        });
        selector.attach({
          field : document.getElementById("company_name"),
          mod : "company", req : "search",
          pick : (d, v) => {
            let coname = document.getElementById("company_name");
            coname.readOnly = true;
            coname.value = d;
            document.getElementById("company_id").value = v;
            document.getElementById("company_unlock").classList.remove("d-none");
          }
        });
        cb.page(2);
      }
    });
  },

  // (E) UNLOCK COMPANY SELECTOR
  unlock : () => {
    let coname = document.getElementById("company_name");
    coname.readOnly = false;
    coname.value = "";
    document.getElementById("company_id").value = "";
    document.getElementById("company_unlock").classList.add("d-none");
  },

  // (F) SAVE JOB
  save : () => {
    // (F1) GET DATA
    var data = {
      title : document.getElementById("job_title").value,
      desc : tinymce.get("job_desc").getContent(),
      cid : document.getElementById("company_id").value
    };
    var id = document.getElementById("job_id").value;
    if (id!="") { data.id = id; }

    // (F2) CHECKS
    if (data.cid=="") {
      cb.modal("Error", "Please select a company (from the auto-suggest).");
      return false;
    }
    if (data.desc=="") {
      cb.modal("Error", "Please enter the job description.");
      return false;
    }

    // (F3) AJAX
    cb.api({
      mod : "jobs",
      req : "save",
      data : data,
      passmsg : "Job Saved",
      onpass : job.list
    });
    return false;
  },

  // (G) DELETE JOB
  //  id : int, job ID
  del : (id) => {
    cb.modal("Please confirm", "Delete job?", () => {
      cb.api({
        mod : "jobs",
        req : "del",
        data : { id: id },
        passmsg : "Job Deleted",
        onpass : job.list
      });
    });
  }
};
window.addEventListener("load", job.list);
