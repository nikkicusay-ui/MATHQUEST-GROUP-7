<div class="filters-section">
    <div class="filters-header">
        <h3><i class="fas fa-database"></i> Question Bank Statistics</h3>
    </div>
    <div class="question-stats">
        @foreach(['Easy','Medium','Hard'] as $difficulty)
            @php
                $stats = $question_stats[$difficulty][0] ?? (object)['total'=>0,'used'=>0,'correct'=>0];
            @endphp
            <div class="question-stat-card {{ strtolower($difficulty) }}">
                <div class="stat-header">
                    <h4>{{ $difficulty }} Questions</h4>
                    <span class="total-count">{{ $stats->total }} total</span>
                </div>
                <div class="stat-details">
                    <div class="stat-detail">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ $stats->correct ?: 0 }} correct answers</span>
                    </div>
                    <div class="stat-detail">
                        <i class="fas fa-play-circle"></i>
                        <span>{{ $stats->used ?: 0 }} times used</span>
                    </div>
                    @if($stats->used > 0)
                        <div class="stat-detail">
                            <i class="fas fa-percentage"></i>
                            <span>{{ round(($stats->correct / $stats->used) * 100, 1) }}% success rate</span>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
