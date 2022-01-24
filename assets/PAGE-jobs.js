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

  // (C) SEARCH FOR JOB
  search : () => {
    job.find = document.getElementById("job-search").value;
    job.pg = 1;
    job.list();
    return false;
  }
};
window.addEventListener("load", job.list);
