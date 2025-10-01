import { Chart } from "@/components/ui/chart"
// Chart.js setup for laporan page

let weeklyChart, monthlyChart

function summarizeWeekly(attendance, jurusanFilter) {
  // Return map of day labels vs counts of 'Hadir' in last 7 days
  const days = []
  const today = new Date()
  for (let i = 6; i >= 0; i--) {
    const d = new Date(today)
    d.setDate(today.getDate() - i)
    days.push(d.toISOString().slice(0, 10))
  }
  const users = JSON.parse(localStorage.getItem("ao_users") || "[]")
  const userById = Object.fromEntries(users.map((u) => [u.id, u]))
  const counts = days.map((date) => {
    const dayRecords = attendance
      .filter((a) => a.date === date)
      .filter((a) => {
        const u = userById[a.userId]
        if (!u) return false
        if (jurusanFilter && jurusanFilter !== "ALL" && u.jurusan !== jurusanFilter) return false
        return true
      })
    return {
      hadir: dayRecords.filter((r) => r.status === "Hadir").length,
      izin: dayRecords.filter((r) => r.status === "Izin").length,
      sakit: dayRecords.filter((r) => r.status === "Sakit").length,
      alpha: dayRecords.filter((r) => r.status === "Alpha").length,
    }
  })
  return { labels: days, data: counts }
}

function summarizeMonthly(attendance, jurusanFilter) {
  // Pie across statuses for current month
  const users = JSON.parse(localStorage.getItem("ao_users") || "[]")
  const userById = Object.fromEntries(users.map((u) => [u.id, u]))
  const now = new Date()
  const ym = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, "0")}`
  const monthRecords = attendance
    .filter((a) => a.date.startsWith(ym))
    .filter((a) => {
      const u = userById[a.userId]
      if (!u) return false
      if (jurusanFilter && jurusanFilter !== "ALL" && u.jurusan !== jurusanFilter) return false
      return true
    })
  return {
    hadir: monthRecords.filter((r) => r.status === "Hadir").length,
    izin: monthRecords.filter((r) => r.status === "Izin").length,
    sakit: monthRecords.filter((r) => r.status === "Sakit").length,
    alpha: monthRecords.filter((r) => r.status === "Alpha").length,
  }
}

function renderWeeklyBar(ctx, weekly) {
  const hadir = weekly.data.map((d) => d.hadir)
  const izin = weekly.data.map((d) => d.izin)
  const sakit = weekly.data.map((d) => d.sakit)
  const alpha = weekly.data.map((d) => d.alpha)
  if (weeklyChart) weeklyChart.destroy()
  weeklyChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: weekly.labels,
      datasets: [
        { label: "Hadir", data: hadir, backgroundColor: "rgba(34,197,94,.7)" },
        { label: "Izin", data: izin, backgroundColor: "rgba(56,189,248,.7)" },
        { label: "Sakit", data: sakit, backgroundColor: "rgba(168,85,247,.7)" },
        { label: "Alpha", data: alpha, backgroundColor: "rgba(239,68,68,.75)" },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: { labels: { color: "#e2e8f0" } },
        tooltip: { enabled: true },
      },
      scales: {
        x: { ticks: { color: "#94a3b8" }, grid: { color: "rgba(148,163,184,.15)" } },
        y: { ticks: { color: "#94a3b8" }, grid: { color: "rgba(148,163,184,.15)" } },
      },
    },
  })
}

function renderMonthlyPie(ctx, month) {
  if (monthlyChart) monthlyChart.destroy()
  monthlyChart = new Chart(ctx, {
    type: "pie",
    data: {
      labels: ["Hadir", "Izin", "Sakit", "Alpha"],
      datasets: [
        {
          data: [month.hadir, month.izin, month.sakit, month.alpha],
          backgroundColor: ["rgba(34,197,94,.8)", "rgba(56,189,248,.8)", "rgba(168,85,247,.8)", "rgba(239,68,68,.85)"],
          borderColor: "rgba(15,23,42,1)",
          borderWidth: 2,
        },
      ],
    },
    options: {
      plugins: {
        legend: { labels: { color: "#e2e8f0" } },
      },
    },
  })
}

function initReportCharts() {
  const jurusanSelect = document.getElementById("filterJurusan")
  const weekCanvas = document.getElementById("weeklyChart")
  const monthCanvas = document.getElementById("monthlyChart")
  const dateInput = document.getElementById("filterTanggal") // can be used to re-summarize if needed

  const rerender = () => {
    const attendance = JSON.parse(localStorage.getItem("ao_attendance") || "[]")
    const jur = jurusanSelect?.value || "ALL"
    const weekly = summarizeWeekly(attendance, jur)
    const monthly = summarizeMonthly(attendance, jur)
    renderWeeklyBar(weekCanvas.getContext("2d"), weekly)
    renderMonthlyPie(monthCanvas.getContext("2d"), monthly)
  }

  jurusanSelect?.addEventListener("change", rerender)
  dateInput?.addEventListener("change", rerender)

  rerender()
}

document.addEventListener("DOMContentLoaded", () => {
  if (document.getElementById("weeklyChart")) {
    initReportCharts()
  }
})
