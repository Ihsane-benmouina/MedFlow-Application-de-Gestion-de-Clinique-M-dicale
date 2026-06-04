<?php

namespace App\Helpers;

class ViewHelper
{
    /**
     * Map of appointment statuses to their Tailwind CSS classes.
     */
    private static array $statusClasses = [
        'En attente' => 'bg-amber-50 text-amber-700 border border-amber-100',
        'Confirmé'   => 'bg-sky-50 text-sky-700 border border-sky-100',
        'Terminé'    => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
        'Annulé'     => 'bg-rose-50 text-rose-700 border border-rose-100',
    ];

    /**
     * Return the CSS classes for a given appointment status badge.
     */
    public static function statusBadgeClass(string $statut): string
    {
        return self::$statusClasses[$statut] ?? 'bg-slate-50 text-slate-700 border border-slate-100';
    }

    /**
     * Render a status badge span element.
     */
    public static function renderStatusBadge(string $statut): string
    {
        $classes = self::statusBadgeClass($statut);
        $escaped = htmlspecialchars($statut);
        return "<span class=\"px-2.5 py-0.5 rounded-md text-xs font-semibold $classes\">$escaped</span>";
    }

    /**
     * Count appointments by status from an array of appointments.
     *
     * @param array $appointments
     * @return array{confirmed: int, pending: int, cancelled: int}
     */
    public static function countByStatus(array $appointments): array
    {
        $counts = ['confirmed' => 0, 'pending' => 0, 'cancelled' => 0];

        foreach ($appointments as $rdv) {
            match ($rdv['statut'] ?? '') {
                'Confirmé' => $counts['confirmed']++,
                'En attente' => $counts['pending']++,
                'Annulé' => $counts['cancelled']++,
                default => null,
            };
        }

        return $counts;
    }

    /**
     * Safely escape and output a string for HTML display.
     */
    public static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
