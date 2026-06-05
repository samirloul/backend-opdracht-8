-- Opdracht 8 - stored procedures

DROP PROCEDURE IF EXISTS sp_unassign_vehicle_from_instructeur;

DELIMITER $$
CREATE PROCEDURE sp_unassign_vehicle_from_instructeur(
    IN p_instructeur_id INT,
    IN p_voertuig_id INT
)
BEGIN
        UPDATE instructeur_voertuigen iv
        INNER JOIN voertuigen v ON v.Id = iv.VoertuigId
        INNER JOIN instructeurs i ON i.Id = iv.InstructeurId
    SET iv.IsActief = b'0',
        iv.Opmerking = 'Toewijzing verwijderd via stored procedure',
        iv.DatumGewijzigd = CURRENT_TIMESTAMP(6)
        WHERE iv.InstructeurId = p_instructeur_id
            AND iv.VoertuigId = p_voertuig_id
            AND iv.IsActief = b'1'
            AND v.IsActief = b'1'
            AND i.IsActief = b'1';
END $$
DELIMITER ;
