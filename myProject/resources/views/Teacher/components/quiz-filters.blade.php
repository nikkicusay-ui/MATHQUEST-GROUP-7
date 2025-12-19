<div class="filters-section">
    <div class="filters-header">
        <h3><i class="fas fa-filter"></i> Filter Quizzes</h3>
    </div>
    <div class="filter-controls">
        <div class="filter-group">
            <label for="quarter-filter"><i class="fas fa-layer-group"></i> Quarter</label>
            <select id="quarter-filter" class="filter-select">
                <option value="all">All Quarters</option>
                <option value="1st">1st Quarter</option>
                <option value="2nd">2nd Quarter</option>
                <option value="3rd">3rd Quarter</option>
                <option value="4th">4th Quarter</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="week-filter"><i class="fas fa-calendar-week"></i> Week</label>
            <select id="week-filter" class="filter-select">
                <option value="all">All Weeks</option>
                @for($i=1;$i<=52;$i++)
                    <option value="{{ $i }}">Week {{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="filter-group">
            <label for="type-filter"><i class="fas fa-tag"></i> Quiz Type</label>
            <select id="type-filter" class="filter-select">
                <option value="all">All Types</option>
                <option value="Mixed">Mixed</option>
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
            </select>
        </div>
    </div>
</div>
