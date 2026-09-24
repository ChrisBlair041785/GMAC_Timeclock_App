-- Creates realistic after-school timeclock history for the previous two months.
-- Existing student/date records are preserved and skipped.
-- This plain INSERT works in phpMyAdmin and older XAMPP MySQL/MariaDB versions.
-- It generates day offsets from 0 through 999; two months needs fewer than 100 days.

INSERT INTO timeclock (StudID, Arrived, Departed)
SELECT
    s.StudID,
    ADDTIME(
        DATE_ADD(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), INTERVAL day_offsets.day_offset DAY),
        SEC_TO_TIME(14 * 3600 + 30 * 60 + FLOOR(RAND() * 90 * 60))
    ),
    ADDTIME(
        DATE_ADD(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), INTERVAL day_offsets.day_offset DAY),
        SEC_TO_TIME(17 * 3600 + FLOOR(RAND() * 90 * 60))
    )
FROM students s
CROSS JOIN (
    SELECT ones.n + tens.n * 10 + hundreds.n * 100 AS day_offset
    FROM
        (SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
         UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) ones
    CROSS JOIN
        (SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
         UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) tens
    CROSS JOIN
        (SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
         UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) hundreds
) AS day_offsets
WHERE DATE_ADD(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), INTERVAL day_offsets.day_offset DAY) <= CURDATE()
  AND WEEKDAY(DATE_ADD(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), INTERVAL day_offsets.day_offset DAY)) < 5
  AND RAND() >= 0.08
  AND NOT EXISTS (
      SELECT 1
      FROM timeclock existing
      WHERE existing.StudID = s.StudID
        AND DATE(COALESCE(existing.Arrived, existing.Departed)) =
            DATE_ADD(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), INTERVAL day_offsets.day_offset DAY)
  );