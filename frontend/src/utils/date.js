export function getLastYears(n) {
  let yearNow = new Date().getFullYear();
  let years = [];

  for (let year = yearNow; year > yearNow - n; year--) {
    years.push(year)
  }

  return years.toString();
}

export function getLastMonths(n) {
  let currentYear = new Date().getFullYear();
  let currentMonth = new Date().getMonth() + 1;
  let years = [];
  let months = [];

  let count = 0;
  while (count !== n) {
    months.push(currentMonth);
    years.push(currentYear);
    if (currentMonth === 1) {
      currentMonth = 12;
      currentYear--;
    } else {
      currentMonth --;
    }

    count++;
  }

  return {
    'years': years.toString(),
    'months': months.toString(),
  };
}
